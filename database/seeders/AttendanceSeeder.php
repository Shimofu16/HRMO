<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $months = [
            Carbon::now()->subMonths(3),
            Carbon::now()->subMonths(2),
            Carbon::now()->subMonths(1),
        ];
        foreach ($months as $index => $month) {
            foreach ($employees as $key => $employee) {
                $this->generateEmployeeSchedule($employee, date('m', strtotime($month)),  now()->format('Y'));
            }
        }
    }

    private function generateEmployeeSchedule($employee, $month, $year)
    {
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $timeIn = '08:00:00'; // 8am
        $defaultTimeIn = Carbon::parse($timeIn);

        $deductionPerMinute =  0.02;
        $deduction =  0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day, rand(7, 10), 0, 0); // Random time in between 7 AM and 10 AM
            $timeOut = $date->copy()->addHours(rand(8, 11)); // Random time out between 3 PM to 6 PM
            if (random_int(0, 1) ==  1) {

                // Check if the day is a weekend and the employee is not "JO"
                if ($date->isWeekend() && $employee->data->category->category_code != "JO") {
                    continue; // Skip to the next iteration
                }
                // Loop to create multiple schedules within a day
                while ($date->lt($timeOut)) {
                    // Check if the day is a weekend and the employee is not "JO"
                    if ($date->isWeekend() && $employee->data->category->category_code != "JO") {
                        $date->addDay(); // Move to the next day
                        continue; // Skip to the next iteration
                    }

                    // Check if employee is on time, half-day or late
                    $timeInStatus = 'On-time';
                    $now = $date->copy()->format('H:i:s');
                    if ($now < $timeIn) {
                        $timeInStatus = 'Half-Day';
                    }
                    if ($now > $timeIn) {
                        $timeInStatus = 'Late';
                        $minuteLate = $defaultTimeIn->diffInMinutes($now);
                        $deduction = $minuteLate * $deductionPerMinute;
                    }

                    // Create attendance record for time in
                    $attendance = Attendance::create([
                        'employee_id' => $employee->id,
                        'time_in_status' => $timeInStatus,
                        'time_in' => $date,
                        'deduction' => $deduction,
                    ]);

                    if ($employee->data->category->category_code == "JO") {
                        $salaryGrade = $employee->data->level->amount;
                        $results = $this->calculateSalary($salaryGrade, $employee, $attendance, $timeOut, true);
                    } else {
                        $salaryGrade = $employee->data->salary_grade_step_amount;
                        $results = $this->calculateSalary($salaryGrade, $employee, $attendance, $timeOut, false);
                    }
                    // Update the attendance record for time out
                    $status = $results['status'];

                    $totalSalaryForToday = $results['salary'];

                    $hoursWorked = $results['hour_worked'];

                    // Update the attendance record
                    $attendance->update([
                        'time_out_status' => $status,
                        'time_out' => $timeOut,
                        'hours' => $hoursWorked,
                        'salary' => $totalSalaryForToday,
                        'isPresent' => 1,
                    ]);

                    $date->addDay(); // Move to the next day
                }
            } else {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'absent_at' => $date
                ]);
            }
        }
    }

    private function calculateSalary($salaryGrade, $employee, $attendance, $attendanceTimeOut, $isJO)
    {
        // Default working days and hours
        $workingDays = 15;
        $requiredHoursWork = 8;

        // Carbon instances for attendance and defaults
        $attendanceTimeIn = Carbon::parse($attendance->time_in);
        $attendanceTimeOut = Carbon::parse($attendanceTimeOut);
        $timeOut = $attendanceTimeOut->copy()->format('H:i:s');
        $defaultTimeIn = Carbon::parse('08:00:00');
        $defaultTimeOut = Carbon::parse('17:00:00');
        $now = $defaultTimeOut->copy()->format('H:i:s');

        // Calculate hours worked, handling negative values and exceeding 8 hours
        $hoursWorked = $defaultTimeIn->diffInHours($attendanceTimeOut, true) - 2;
        $hoursWorked = max(0, min($hoursWorked, $requiredHoursWork)); // Ensure 0-8 hours

        // Calculate minutes late
        $minutesLate = $defaultTimeIn->diffInMinutes($attendanceTimeIn);

        // Calculate salary per hour (applicable only for non-JO employees)
        if (!$isJO) {
            $subTotal = ($salaryGrade / 2) / ($workingDays * $requiredHoursWork);
            $salaryPerHour = $subTotal;

            // Sick leave handling (requires a `computeSickLeave` function)
            $sickLeave = $employee->data->sick_leave_points;
            if ($sickLeave > 0) {
                $sickLeave = $this->computeSickLeave($sickLeave, $minutesLate);
            }
        }

        // Determine attendance status and adjust salary (if applicable)
        $status = ($timeOut < $now) ? 'Under-time' : 'Time-out';
        if (!$isJO && $timeOut < $now) {
            $notWorkedHour = $defaultTimeOut->diffInHours($timeOut);
            $salaryPerHour -= $notWorkedHour;
        }

        // Calculate total salary for the day (applicable only for non-JO employees)
        if (!$isJO) {
            $totalSalaryForToday = max(0, $salaryPerHour * $hoursWorked); // Ensure non-negative
            if ($attendance->time_in_status === 'Late') {
                $totalSalaryForToday -= ($sickLeave === 0) ? $this->getLateByMinutes($minutesLate) : 0;
            }
            $employee->data->update(['sick_leave_points' => $sickLeave]);
        } else {
            $totalSalaryForToday = $salaryGrade;
        }

        return [
            'salary' => $totalSalaryForToday,
            'status' => $status,
            'hour_worked' => $hoursWorked,
        ];
    }

    private function computeSickLeave($sickLeave, $minuteLate)
    {
        $sickLeaveLeft = 0;

        // Compute the sick leave deduction per minute
        $sickLeaveLeft = $sickLeave - $this->getLateByMinutes($minuteLate);

        // check if sickLeaveLeft is less than 0
        if ($sickLeaveLeft < 0) {
            $sickLeaveLeft = 0;
        }

        return $sickLeaveLeft;
    }

    private function getLateByMinutes($minuteLate)
    {
        $equivalentMinutes = [
            1 => 0.002, 2 => 0.004, 3 => 0.006, 4 => 0.008, 5 => 0.010,
            6 => 0.012, 7 => 0.014, 8 => 0.017, 9 => 0.019, 10 => 0.021,
            11 => 0.023, 12 => 0.025, 13 => 0.027, 14 => 0.029, 15 => 0.031,
            16 => 0.033, 17 => 0.035, 18 => 0.037, 19 => 0.040, 20 => 0.042,
            21 => 0.044, 22 => 0.046, 23 => 0.048, 24 => 0.050, 25 => 0.052,
            26 => 0.054, 27 => 0.056, 28 => 0.058, 29 => 0.060, 30 => 0.062,
            31 => 0.065, 32 => 0.067, 33 => 0.069, 34 => 0.071, 35 => 0.073,
            36 => 0.075, 37 => 0.077, 38 => 0.079, 39 => 0.081, 40 => 0.083,
            41 => 0.085, 42 => 0.087, 43 => 0.090, 44 => 0.092, 45 => 0.094,
            46 => 0.096, 47 => 0.098, 48 => 0.100, 49 => 0.102, 50 => 0.104,
            51 => 0.106, 52 => 0.108, 53 => 0.110, 54 => 0.112, 55 => 0.114,
            56 => 0.117, 57 => 0.119, 58 => 0.121, 59 => 0.123, 60 => 0.125
        ];
        if (array_key_exists($minuteLate, $equivalentMinutes)) {
            return $equivalentMinutes[$minuteLate];
        } else {
            return 0;
        }
    }
}
