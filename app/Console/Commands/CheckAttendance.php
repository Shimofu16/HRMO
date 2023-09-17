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
    protected $signature = 'app:attendance';

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
                ->whereDate('created_at', Carbon::today())
                ->first();
            if (!$attendance) {
                // Employee has not timed in, show error message
                $this->info('Employee ' . $employee->name . ' has not timed in for today!');
                // create attendance for employee
                Attendance::create([
                    'employee_id' => $employee->id,
                    'status' => 'absent',
                    'isPresent' => 0,
                ]);
            }
            // check if employee has timed out
            if ($attendance->time_out == null) {
                $status = 'Automatic Time-out';
                $timezone = 'Asia/Manila'; // Set the timezone to the Philippines

                Carbon::setLocale('en'); // Set the locale for Carbon if needed
                Carbon::setToStringFormat('Y-m-d H:i:s'); // Set the string format for Carbon objects if needed

                $now = Carbon::now($timezone);

                $salary_grade = $employee->sgrade->sg_amount;
                $working_days = 15;
                $required_hours_work = 8;
                $subTotal = (($salary_grade / 2) / $working_days) / $required_hours_work;

                $defaultTimeIn = Carbon::parse('08:01:00');
                $defaultTimeOut = Carbon::parse('17:59:00');
                $attendanceTimeIn = Carbon::parse($attendance->time_in);




                // Calculate the hours worked
                $hour_worked = $attendanceTimeIn->diffInHours($defaultTimeOut);

                // Calculate the minutes late
                $minute_late = $defaultTimeIn->diffInMinutes($attendance->time_in);

                $currentMonth = Carbon::now()->format('m');

                // Check if the employee's sick leave was updated this month
                if ($employee->sickLeave->updated_at->format('m') != $currentMonth) {
                    // Update the employee's sick leave
                    $employee->sickLeave->update(['sick_leave_balance' => $employee->sickLeave->sick_leave_balance + 1.25]);
                }

                // Get the employee's sick leave balance
                $sick_leave = $employee->sickLeave->sick_leave_balance;

                // check if the employee has sick leave left
                if ($sick_leave > 0) {
                    $sick_leave = $this->computeSickLeave($sick_leave, $minute_late);
                }

                // Calculate the salary per hour
                $salary_per_hour = $subTotal;

                // Calculate the total salary for the day
                $total_salary_for_today = ($salary_per_hour * $hour_worked) - (($sick_leave == 0) ? $minute_late : 0);

                // Ensure that the total salary is not negative
                if ($total_salary_for_today < 0) {
                    $total_salary_for_today = 0;
                }

                // Set the status to the previous status concatenated with the new status
                $status = $attendance->status . '/' . $status;

                // Update the employee's sick leave
                $employee->sickLeave->update(['sick_leave_balance' => $sick_leave]);

                // Update the attendance record
                $attendance->update([
                    'status' => $status,
                    'time_out' => $now,
                    'salary' => $total_salary_for_today,
                    'isPresent' => 1,
                ]);
            }
        }
    }
}
