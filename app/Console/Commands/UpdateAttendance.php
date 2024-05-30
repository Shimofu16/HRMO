<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\FingerClock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:update-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update attendance from biometric';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         // Get the current date
         $current_date = Carbon::now();

         // Get all employees
         $employees = Employee::all();

         foreach ($employees as $employee) {
             // Get attendance records for the current date
             $attendances = FingerClock::where('namee', $employee->employee_number)
                 ->where('Datee', $current_date->format('l, F d, Y'))
                 ->orderBy('timee', 'asc')
                 ->get();
             // dd($attendances, $current_date->format('l, F d, Y'));
             if ($attendances->isNotEmpty()) {
                 // Get the first and last attendance records for time in and time out
                 $time_in = $attendances->last()->timee;
                 $time_out = $attendances->first()->timee;

                 // Check if the employee has already timed in for the day
                 $existingTimeIn = $employee->attendances()
                     ->whereDate('time_in', $current_date->format('Y-m-d'))
                     ->first();

                 if (!$existingTimeIn) {
                     $now_time_in = Carbon::parse($time_in);
                     $current_time_time_in = $now_time_in->format('H:i:s');
                     $timeIn = '08:00:00';
                     $defaultTimeIn = Carbon::parse('08:00:00'); // 8am
                     $tenAMThreshold = '10:00:00'; // 10:00am
                     $timeOut = '17:00:00'; // 5pm
                     $time_in_deduction = 0;
                     $time_out_deduction = 0;

                     // Determine the status based on time in
                     if ($current_time_time_in <= $timeIn) {
                         $status = 'On-time';
                     } elseif ($current_time_time_in >= $tenAMThreshold) {
                         $status = 'Half-Day';
                         $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time_time_in));
                         $time_in_deduction = getLateByMinutes($minute_late);
                     } else {
                         $status = 'Late';
                         $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time_time_in));
                         $time_in_deduction = getLateByMinutes($minute_late);
                     }

                     if ($employee->data->category->category_code == "JO" || $employee->data->sick_leave_points == 0) {
                         $time_in_deduction = 0;
                     }

                     // Create attendance record for time in
                     $attendance = Attendance::create([
                         'employee_id' => $employee->id,
                         'time_in_status' => $status,
                         'time_in' => $now_time_in,
                         'time_in_deduction' => $time_in_deduction,
                     ]);

                     $now_time_out = Carbon::parse($time_out);
                     $current_time_time_out = $now_time_out->format('H:i:s');
                     $salary_grade = $employee->data->monthly_salary;
                     $results = calculateSalary($salary_grade, $employee, $attendance, $timeIn, $timeOut, $current_time_time_out, $employee->data->category->category_code == "JO");

                     $status = $results['status'];
                     $total_salary_for_today = $results['salary'];
                     $hours = $results['hour_worked'];
                     $time_out_deduction = $results['deduction'];

                     // Update the attendance record
                     $attendance->update([
                         'time_out_status' => $status,
                         'time_out' => $now_time_out,
                         'hours' => $hours,
                         'salary' => $total_salary_for_today,
                         'time_out_deduction' => $time_out_deduction,
                         'isPresent' => 1,
                     ]);
                 }
             }
         }
    }
}
