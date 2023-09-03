<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
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
            $attendance = Attendance::where('employee_id', $employee->id)->whereDate('created_at', \Carbon\Carbon::today())->first();
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
        }
    }
}
