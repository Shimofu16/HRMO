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
        $current_date = Carbon::now();
        $employees = Employee::all();
        foreach ($employees as $key => $employee) {
            $temp_attendances = FingerClock::where('namee', $employee->employee_number)
                ->latest()
                ->get();
            // dd($temp_attendances);
            if (count($temp_attendances) > 0) {
                $attendances = collect();
                foreach ($temp_attendances as $key => $temp_attendance) {
                    // dd($temp_attendance->date == $current_date->format('Y-m-d'), $temp_attendance->date, $current_date->format('Y-m-d'));
                    if ($temp_attendance->date == $current_date->format('Y-m-d')) {
                        $attendances[] = $temp_attendance;
                    }
                }
                $time_in = '';
                $time_out = '';
                foreach ($attendances as $key => $attendance) {
                    if ($attendance->time < '12:00:00') {
                        $time_in = $attendance->time;
                    } else {
                        $time_out = $attendance->time;
                    }
                }
                // Check if the employee has already timed in for the day
                $existingTimeIn = $employee->attendances()
                    ->whereDate('time_in', $current_date)
                    ->first();
                if (!$existingTimeIn) {
                    $now_time_in = Carbon::parse($time_in);
                    // dd($existingTimeIn,$time_in, $attendances);
                    $current_time_time_in = $now_time_in->format('H:i:s');
                    $timeIn = '08:00:00';
                    $defaultTimeIn = Carbon::parse('08:00:00'); // 8am
                    $tenAMThreshold = '10:00:00'; // 10:00am
                    $timeOut = '17:00:00'; // 5pm
                    $time_in_deduction =  0;
                    $time_out_deduction =  0;

                    // Check if employee is on time, half-day or late
                    if ($current_time_time_in < $timeIn || $current_time_time_in <= $timeIn) {
                        $status = 'On-time';
                    } elseif ($current_time_time_in >= $tenAMThreshold) {
                        $status = 'Half-Day';
                        $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time_time_in));
                        $time_in_deduction = getLateByMinutes($minute_late);
                    } elseif ($current_time_time_in > $timeIn) {
                        $status = 'Late';
                        $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time_time_in));
                        $time_in_deduction = getLateByMinutes($minute_late);
                    }
                    if ($employee->data->category->category_code == "JO" || $employee->data->sick_leave_points < 0) {
                        $time_in_deduction = 0;
                    }

                    // Create attendance record for time in
                    $attendance =    Attendance::create([
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
                        'time_in_deduction' => ($time_out_deduction == 0) ? 0 : $attendance->time_in_deduction ,
                        'time_out_deduction' => $time_out_deduction,
                        'isPresent' => 1,
                    ]);
                }
            }
            // dd($time_in, $time_out);
        }
    }
}
