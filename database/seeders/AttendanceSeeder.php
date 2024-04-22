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
        foreach ($employees as $key => $employee) {
            $this->generateEmployeeSchedule($employee, now()->format('m'),  now()->format('Y'));
        }
    }
    private function generateEmployeeSchedule($employee, $month, $year)
    {
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day, 7, 0, 0); // Start time at 7 am
            $timeOut = $date->copy()->addHours(rand(9, 11)); // Randomly set time out between 4 pm to 6 pm

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

                // Calculate salary for the day


                // Create attendance record for time in
                $attendance = Attendance::create([
                    'employee_id' => $employee->id,
                    'time_in_status' => 'On-time',
                    'time_in' => $date,
                ]);
                if ($employee->data->category->category_code == "JO") {
                    $salary_grade = $employee->data->level->amount;
                    $results = $this->calculateSalary($salary_grade, $attendance, $timeOut, true);
                }else{
                    $salary_grade = $employee->data->salary_grade_step_amount;
                    $results = $this->calculateSalary($salary_grade, $attendance, $timeOut, false);
                }
                // Update the attendance record for time out
                $status = $results['status'];

                $total_salary_for_today = $results['salary'];

                $hours = $results['hour_worked'];

                // Update the attendance record
                $attendance->update([
                    'time_out_status' => $status,
                    'time_out' => $timeOut,
                    'hours' => $hours,
                    'salary' => $total_salary_for_today,
                    'isPresent' => 1,
                ]);

                $date->addDay(); // Move to the next day
            }
        }
    }
    private function calculateSalary($salaryGrade, $attendance, $timeOut, $isJO)
    {
        // Default working days and hours
        $workingDays = 15;
        $requiredHoursWork = 8;

        // Carbon instances for attendance and defaults
        $attendanceTimeIn = Carbon::parse($attendance->time_in);
        $attendanceTimeOut = Carbon::parse($timeOut);

        // Calculate hours worked, handling negative values and exceeding 8 hours
        $hourWorked = $attendanceTimeIn->diffInHours($attendanceTimeOut, true) - 1;
        $hourWorked = max(0, min($hourWorked, $requiredHoursWork)); // Ensure 0-8 hours


        // Determine attendance status and adjust salary (if applicable)
        $status = 'Time-out';

        // Calculate total salary for the day (applicable only for non-JO employees)
        if (!$isJO) {
            $salaryPerHour =  ($salaryGrade / 2) / ($workingDays * $requiredHoursWork);
            $totalSalaryForToday = max(0, $salaryPerHour * $hourWorked); // Ensure non-negative
        } else {
            $totalSalaryForToday = $salaryGrade;
        }

        return [
            'salary' => $totalSalaryForToday,
            'status' => $status,
            'hour_worked' => $hourWorked,
        ];
    }


}
