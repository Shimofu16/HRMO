<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->whereDate('created_at', now())->get();
        // dd($attendances);

        $employees = Employee::all();

        return view('attendances.index', compact('attendances', 'employees'));
    }




    private function checkStatus($isTimeIn, $attendance = null)
    {
        $status = '';
        $timezone = 'Asia/Manila'; // Set the timezone to the Philippines

        Carbon::setLocale('en'); // Set the locale for Carbon if needed
        Carbon::setToStringFormat('Y-m-d H:i:s'); // Set the string format for Carbon objects if needed

        $now = Carbon::now($timezone);
        $current_time = $now->format('H:i:s');
        // $current_time =  '08:30:00'; // 8:30am
        // $current_time =  '15:00:00'; // 3pm
        $timeIn = '08:00:00'; // 8am
        $lateThreshold = '08:10:00'; // 8:10am
        $timeOut = '17:00:00'; // 5pm

        if ($isTimeIn) {
            if ($current_time >= $timeIn && $current_time <= $lateThreshold) {

                $status = 'On-Time';
            } elseif ($current_time > $lateThreshold) {
                $status = 'Late'; // Return "late" instead of "absent" if the employee times in after the allowed threshold but before the late threshold.
            }
        } else {
            //(((((salaryGrade)/2)/working days)/8hrs)-NotWorkedHour)
            $salary_grade = $attendance->employee->sgrade->sg_amount;
            $working_days = 15;
            $required_hours_work = 8;
            $not_worked_hour = 0;
            $total_salary_for_today = 0;
            $salary_per_hour = 0;
            $minute_late = 0;
            $hour_worked = 0;
            $subTotal = (($salary_grade / 2) / $working_days) / $required_hours_work;
            if ($current_time <= $timeOut) {
                $status = 'Under-time';
                // get the difference in minutes
                $diff = $now->diffInMinutes($current_time);
                $not_worked_hour = $diff / 60;
                $salary_per_hour = $subTotal - $not_worked_hour;
            }

            if ($attendance->status == 'Late') {
                // get how many minutes late
                $diff = $now->diffInMinutes($attendance->time_in);
                $minute_late = $diff / 60;
            }
            // get hours of worked
            $diff = $now->diffInMinutes($current_time);
            $hour_worked = $diff / 60;

            $total_salary_for_today = ($salary_per_hour * $hour_worked) - $minute_late;
            // dd($total_salary_for_today,$salary_per_hour,$hour_worked,$minute_late,$subTotal,$salary_grade,$not_worked_hour);
            //salary per attendance
            $status = $attendance->status . '/' . $status;
            $attendance->update([
                'status' => $status,
                'time_out' => now(),
                'salary' => $total_salary_for_today,
            ]);
        }

        return $status;
    }
    // public function setAbsents()
    // {
    //     // get all the employee without attendance today
    //     $employees = Employee::whereDoesntHave('attendances', function ($query) {
    //         $query->whereDate('created_at', now());
    //     })->get();
    //     foreach ($employees as $employee) {
    //         Attendance::create([
    //             'employee_id' => $employee->id,
    //             'status' => 'Absent',
    //             'time_in' => now(),
    //             'time_out' => now(),
    //         ]);
    //     }
    // }




    public function store(Request $request)
    {
        // check if the time is 10 am
         if (now()->format('H:i:s') >= '10:00:00') {
            return redirect()->back()->with('error', 'Attendance time is over!');
        }
        $request->validate([
            'employee_id' => 'required|exists:employees,emp_no',
        ]);
        $employee = Employee::where('emp_no', $request->input('employee_id'))->first();

        // Check if the employee has attendance for the current date
        $existingAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('time_in', Carbon::today())
            ->first();

        if (!$existingAttendance) {
            // Create a new attendance record only if it doesn't exist for the current date
            $status = $this->checkStatus(true);

            Attendance::create([
                'employee_id' => $employee->id,
                'status' => $status,
                'time_in' => now(),
            ]);

            return redirect()->back()->with('success', 'Attendance recorded successfully!');
        }

        return redirect()->back()->with('error', 'Attendance already recorded for the day!');
    }
    public function update($id)
    {
        $attendance = Attendance::find($id);
        $attendance = Attendance::find($id);
        $this->checkStatus(false, $attendance);

        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }

    public function create()
    {
        // Retrieve attendance history records and pass them to the view
        $attendanceHistory = Attendance::with('employee')->orderBy('created_at', 'desc')->get();
        return view('attendances.history', compact('attendanceHistory'));
    }
}
