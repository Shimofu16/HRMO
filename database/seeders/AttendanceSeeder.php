<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

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
        $tenAMThreshold = '10:00:00'; // 10:00am
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
                    $now = $date->copy()->format('H:i:s');
                    if ($now < $timeIn || $now <= $timeIn) {
                        $timeInStatus = 'On-time';
                    } elseif ($now >= $tenAMThreshold) {
                        $timeInStatus = 'Half-Day';
                    } elseif ($now > $timeIn) {
                        $timeInStatus = 'Late';
                        $minute_late = $defaultTimeIn->diffInMinutes($now);
                        $deduction = getLateByMinutes($minute_late);
                    }



                    // Create attendance record for time in
                    $attendance = Attendance::create([
                        'employee_id' => $employee->id,
                        'time_in_status' => $timeInStatus,
                        'time_in' => $date,
                        'time_in_deduction' => $deduction,
                    ]);
                    $results = calculateSalary($employee->data->monthly_salary, $employee, $attendance, '08:00:00', '17:00:00', $timeOut, $employee->data->category->category_code == "JO");
                    $status = $results['status'];
                    Log::info("Date: $date, Time Out: $timeOut, Time In Status: $timeInStatus, Time Out Status:$status");

                    // Update the attendance record for time out

                    $totalSalaryForToday = $results['salary'];

                    $hoursWorked = $results['hour_worked'];
                    $deduction = $results['deduction'];

                    // Update the attendance record
                    $attendance->update([
                        'time_out_status' => $status,
                        'time_out' => $timeOut,
                        'hours' => $hoursWorked,
                        'salary' => $totalSalaryForToday,
                        'isPresent' => 1,
                        'time_out_deduction' => $deduction,
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
    // private function calculateSalary($salaryGrade, $employee, $attendance, $timeIn, $timeOut, $currentTime, $isJO)
    // {
    //     // Default working days and hours
    //     $workingDays = 15;
    //     $requiredHoursWork = 8;

    //     // Carbon instances for attendance and defaults
    //     $attendanceTimeIn = Carbon::parse($attendance->time_in);
    //     $attendanceTimeOut = Carbon::parse( $currentTime);
    //     $formattedTimeout = $attendanceTimeOut->copy()->format('H:i:s');
    //     $defaultTimeIn = Carbon::parse( $timeIn);
    //     $defaultTimeOut = Carbon::parse( $timeOut);
    //     $formattedDefaultTimeOut = $defaultTimeOut->copy()->format('H:i:s');
    //     // Calculate hours worked, handling negative values and exceeding 8 hours
    //     if ($formattedTimeout > $formattedDefaultTimeOut) {
    //         $hourWorked = $defaultTimeIn->diffInHours($defaultTimeOut, true) - 1;
    //     }else{
    //         $hourWorked = $defaultTimeIn->diffInHours($attendanceTimeOut, true) - 1;
    //     }
    //     if ($hourWorked > $requiredHoursWork) {
    //         $hourWorked =  8;
    //     }
    //     if ($hourWorked < 0) {
    //         $hourWorked =  0;
    //     }

    //     // Calculate minutes late
    //     $minutesLate = $defaultTimeIn->diffInMinutes($attendanceTimeIn);

    //     // Calculate salary per hour (applicable only for non-JO employees)
    //     if (!$isJO) {
    //         $salaryPerHour = ($salaryGrade / 22) / $requiredHoursWork;

    //         // Sick leave handling (requires a `computeSickLeave` function)
    //         $sickLeave = $employee->data->sick_leave_points;
    //         if ($sickLeave > 0) {
    //             $sickLeave =$this->computeSickLeave($sickLeave, $minutesLate);
    //         }
    //     }

    //     // Determine attendance status and adjust salary (if applicable)
    //     $status = ($formattedTimeout < $formattedDefaultTimeOut) ? 'Under-time' : 'Time-out';

    //     if (!$isJO && $status == 'Under-time') {
    //         $notWorkedHour = $defaultTimeOut->diffInHours($attendanceTimeOut);
    //         $salaryPerHour = $salaryPerHour - $notWorkedHour;

    //         $sickLeave = $sickLeave - ($notWorkedHour * 1.25);
    //         if ($sickLeave < 0) {
    //             $sickLeave = 0;
    //         }
    //     }

    //     // Calculate total salary for the day (applicable only for non-JO employees)
    //     if (!$isJO) {
    //         $totalSalaryForToday = (($salaryPerHour * $hourWorked) < 0) ? 0 : ($salaryPerHour * $hourWorked);
    //         if ($attendance->time_in_status === 'Late') {
    //             $totalSalaryForToday = $totalSalaryForToday - ($sickLeave === 0) ?$this->getLateByMinutes($minutesLate) : 0;
    //         }
    //         $employee->data->update(['sick_leave_points' => $sickLeave]);
    //     } else {
    //         if ($attendance->time_in_status === 'Half-Day') {
    //             $totalSalaryForToday = $salaryGrade / 2;
    //         } else {
    //             $totalSalaryForToday = $salaryGrade;
    //         }
    //     }

    //     return [
    //         'salary' => $totalSalaryForToday,
    //         'status' => $status,
    //         'hour_worked' => $hourWorked,
    //     ];
    // }
    // private function computeSickLeave($sick_leave, $minute_late)
    // {
    //     $sick_leave_left = 0;

    //     // Compute the sick leave deduction per minute
    //     $sick_leave_left = $sick_leave - $this->getLateByMinutes($minute_late);

    //     // check if sick_leave_left is less than 0
    //     if ($sick_leave_left < 0) {
    //         $sick_leave_left = 0;
    //     }

    //     return $sick_leave_left;
    // }
    // private function getLateByMinutes($minute_late)
    // {
    //     $equivalentMinutes = [
    //         1 => 0.002, 2 => 0.004, 3 => 0.006, 4 => 0.008, 5 => 0.010,
    //         6 => 0.012, 7 => 0.014, 8 => 0.017, 9 => 0.019, 10 => 0.021,
    //         11 => 0.023, 12 => 0.025, 13 => 0.027, 14 => 0.029, 15 => 0.031,
    //         16 => 0.033, 17 => 0.035, 18 => 0.037, 19 => 0.040, 20 => 0.042,
    //         21 => 0.044, 22 => 0.046, 23 => 0.048, 24 => 0.050, 25 => 0.052,
    //         26 => 0.054, 27 => 0.056, 28 => 0.058, 29 => 0.060, 30 => 0.062,
    //         31 => 0.065, 32 => 0.067, 33 => 0.069, 34 => 0.071, 35 => 0.073,
    //         36 => 0.075, 37 => 0.077, 38 => 0.079, 39 => 0.081, 40 => 0.083,
    //         41 => 0.085, 42 => 0.087, 43 => 0.090, 44 => 0.092, 45 => 0.094,
    //         46 => 0.096, 47 => 0.098, 48 => 0.100, 49 => 0.102, 50 => 0.104,
    //         51 => 0.106, 52 => 0.108, 53 => 0.110, 54 => 0.112, 55 => 0.114,
    //         56 => 0.117, 57 => 0.119, 58 => 0.121, 59 => 0.123, 60 => 0.125
    //     ];
    //     if (array_key_exists($minute_late, $equivalentMinutes)) {
    //         return $equivalentMinutes[$minute_late];
    //     } else {
    //         return 0;
    //     }
    // }


    // private function calculateSalary($salaryGrade, $employee, $attendance, $attendanceTimeOut, $isJO)
    // {
    //     // Default working days and hours
    //     $workingDays = 15;
    //     $requiredHoursWork = 8;

    //     // Carbon instances for attendance and defaults
    //     $attendanceTimeIn = Carbon::parse($attendance->time_in);
    //     $attendanceTimeOut = Carbon::parse($attendanceTimeOut);
    //     $timeOut = $attendanceTimeOut->copy()->format('H:i:s');
    //     $defaultTimeIn = Carbon::parse('08:00:00');
    //     $defaultTimeOut = Carbon::parse('17:00:00');
    //     $now = $defaultTimeOut->copy()->format('H:i:s');

    //     // Calculate hours worked, handling negative values and exceeding 8 hours
    //     $hoursWorked = $defaultTimeIn->diffInHours($attendanceTimeOut, true) - 2;
    //     $hoursWorked = max(0, min($hoursWorked, $requiredHoursWork)); // Ensure 0-8 hours

    //     // Calculate minutes late
    //     $minutesLate = $defaultTimeIn->diffInMinutes($attendanceTimeIn);

    //     // Calculate salary per hour (applicable only for non-JO employees)
    //     if (!$isJO) {
    //         $subTotal = ($salaryGrade / 2) / ($workingDays * $requiredHoursWork);
    //         $salaryPerHour = $subTotal;

    //         // Sick leave handling (requires a `computeSickLeave` function)
    //         $sickLeave = $employee->data->sick_leave_points;
    //         if ($sickLeave > 0) {
    //             $sickLeave = $this->computeSickLeave($sickLeave, $minutesLate);
    //         }
    //     }

    //     // Determine attendance status and adjust salary (if applicable)
    //     $status = ($timeOut < $now) ? 'Under-time' : 'Time-out';
    //     if (!$isJO && $timeOut < $now) {
    //         $notWorkedHour = $defaultTimeOut->diffInHours($timeOut);
    //         $salaryPerHour -= $notWorkedHour;
    //     }

    //     // Calculate total salary for the day (applicable only for non-JO employees)
    //     if (!$isJO) {
    //         $totalSalaryForToday = max(0, $salaryPerHour * $hoursWorked); // Ensure non-negative
    //         if ($attendance->time_in_status === 'Late') {
    //             $totalSalaryForToday -= ($sickLeave === 0) ? $this->getLateByMinutes($minutesLate) : 0;
    //         }
    //         $employee->data->update(['sick_leave_points' => $sickLeave]);
    //     } else {
    //         $totalSalaryForToday = $salaryGrade;
    //     }

    //     return [
    //         'salary' => $totalSalaryForToday,
    //         'status' => $status,
    //         'hour_worked' => $hoursWorked,
    //     ];
    // }

    // private function computeSickLeave($sickLeave, $minuteLate)
    // {
    //     $sickLeaveLeft = 0;

    //     // Compute the sick leave deduction per minute
    //     $sickLeaveLeft = $sickLeave - $this->getLateByMinutes($minuteLate);

    //     // check if sickLeaveLeft is less than 0
    //     if ($sickLeaveLeft < 0) {
    //         $sickLeaveLeft = 0;
    //     }

    //     return $sickLeaveLeft;
    // }

    // private function getLateByMinutes($minuteLate)
    // {
    //     $equivalentMinutes = [
    //         1 => 0.002, 2 => 0.004, 3 => 0.006, 4 => 0.008, 5 => 0.010,
    //         6 => 0.012, 7 => 0.014, 8 => 0.017, 9 => 0.019, 10 => 0.021,
    //         11 => 0.023, 12 => 0.025, 13 => 0.027, 14 => 0.029, 15 => 0.031,
    //         16 => 0.033, 17 => 0.035, 18 => 0.037, 19 => 0.040, 20 => 0.042,
    //         21 => 0.044, 22 => 0.046, 23 => 0.048, 24 => 0.050, 25 => 0.052,
    //         26 => 0.054, 27 => 0.056, 28 => 0.058, 29 => 0.060, 30 => 0.062,
    //         31 => 0.065, 32 => 0.067, 33 => 0.069, 34 => 0.071, 35 => 0.073,
    //         36 => 0.075, 37 => 0.077, 38 => 0.079, 39 => 0.081, 40 => 0.083,
    //         41 => 0.085, 42 => 0.087, 43 => 0.090, 44 => 0.092, 45 => 0.094,
    //         46 => 0.096, 47 => 0.098, 48 => 0.100, 49 => 0.102, 50 => 0.104,
    //         51 => 0.106, 52 => 0.108, 53 => 0.110, 54 => 0.112, 55 => 0.114,
    //         56 => 0.117, 57 => 0.119, 58 => 0.121, 59 => 0.123, 60 => 0.125
    //     ];
    //     if (array_key_exists($minuteLate, $equivalentMinutes)) {
    //         return $equivalentMinutes[$minuteLate];
    //     } else {
    //         return 0;
    //     }
    // }
}
