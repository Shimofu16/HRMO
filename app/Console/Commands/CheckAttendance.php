<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Attendance of all the employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking Attendance of all the employees');
        // Get all employees
        $employees = Employee::all();
        // Loop through each employee
        foreach ($employees as $employee) {
            // check if employee has attendance for today
            $attendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('time_in', Carbon::today())
                ->first();
            if (!$attendance) {
                // Employee has not timed in, show error message
                $this->info('Employee ' . $employee->full_name . ' has not timed in for today!');
                // create attendance for employee
                Attendance::create([
                    'employee_id' => $employee->id,
                    'status' => 'absent',
                    'isPresent' => 0,
                ]);
            }

        }
    }
    private function calculateSalary($salary_grade, $employee, $attendance, $timeIn, $timeOut, $current_time)
    {
        $working_days = 15;

        $required_hours_work = 8;
        $subTotal = (($salary_grade / 2) / $working_days) / $required_hours_work;

        // Create Carbon instances for the default time in and time out
        $defaultTimeIn = Carbon::parse($timeIn);
        $defaultTimeOut = Carbon::parse($timeOut);

        $attendanceTimeIn = Carbon::parse($attendance->time_in);
        $attendanceTimeOut = Carbon::parse($attendance->time_out);

        // Calculate the hours worked
        $hour_worked = $attendanceTimeIn->diffInHours($attendanceTimeOut) - 1;

        if ($hour_worked < 0) {
            $hour_worked = 0;
        }

        if ($hour_worked > 8) {
            $hour_worked = 8;
        }

        // Calculate the minutes late
        $minute_late = $defaultTimeIn->diffInMinutes($attendance->time_in);

        // Get the employee's sick leave balance
        $sick_leave = $employee->data->sick_leave_points;

        // check if the employee has sick leave left
        if ($sick_leave > 0) {
            $sick_leave = $this->computeSickLeave($sick_leave, $minute_late);
        }

        // Check if the current time is less than the time out
        if ($current_time < $timeOut) {
            $status = 'Under-time';
            // Calculate the difference in minutes between the default time out and the current time
            $diff = $defaultTimeOut->diffInMinutes($current_time);
            $not_worked_hour = $diff / 60;
            $salary_per_hour = $subTotal - $not_worked_hour;
        } elseif ($current_time > $timeOut) {
            $salary_per_hour = $subTotal;
            $status = 'Time-out';
        }

        // Calculate the total salary for the day
        $total_salary_for_today = ($salary_per_hour * $hour_worked);
        if ($attendance->time_in_status === 'Late') {
            $total_salary_for_today  = $total_salary_for_today - (($sick_leave == 0) ? $this->getLateByMinutes($minute_late) : 0);
        }

        // Ensure that the total salary is not negative
        if ($total_salary_for_today < 0) {
            $total_salary_for_today = 0;
        }
        // Update the employee's sick leave
        $employee->data->update(['sick_leave_points' => $sick_leave]);


        return [
            'salary' => $total_salary_for_today,
            'status' => $status,
            'hour_worked' => $hour_worked,
        ];
    }
}
