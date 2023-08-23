<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->whereDate('created_at', now())->get();
        // dd($attendances);

        $employees = Employee::all();

        return view('attendances.index', compact('attendances', 'employees'));
    }




    private function checkStatus($isTimeIn, $image, $attendance = null, $employee = null)
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

        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode(end($image_parts));
        $fileName = uniqid() . '' . '.png';
        $path = 'uploads/attendance/';


        if ($isTimeIn) {
            $path = $path . $employee->name . '/';
            $fileName = uniqid() . ' Time in' . '.png';
            $filePath = $path . $fileName;
            if ($current_time >= $timeIn && $current_time <= $lateThreshold) {

                $status = 'On-Time';
            } elseif ($current_time > $lateThreshold) {
                $status = 'Late'; // Return "late" instead of "absent" if the employee times in after the allowed threshold but before the late threshold.
            }
            Attendance::create([
                'employee_id' => $employee->id,
                'status' => $status,
                'time_in' => now(),
                'time_in_image' => $filePath,
            ]);
        } else {
            $path = $path . $attendance->employee->name . '/';
            $fileName = uniqid() . ' Time out' . '.png';
            $filePath = $path . $fileName;
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
            $status = 'On-Time';
            $salary_per_hour = $subTotal;
            $attendance_timeIn = Carbon::parse($attendance->time_in);
            $defaultTimeIn = Carbon::parse($timeIn);
            $defaultTimeOut = Carbon::parse($timeOut);
            // if the current time is less than the time out
            if ($current_time <= $timeOut) {
                $status = 'Under-time';
                // get the difference in minutes
                $diff = $defaultTimeOut->diffInMinutes($current_time);
                $not_worked_hour = $diff / 60;
                $salary_per_hour = $subTotal - $not_worked_hour;
            }
            // Convert the string values to Carbon objects
            $attendance_timeIn = Carbon::parse($attendance->time_in);
            $defaultTimeIn = Carbon::parse($timeIn);

            if ($attendance->status == 'Late') {
                // get how many minutes late
                $minute_late = $defaultTimeIn->diffInMinutes($attendance->time_in);
            }
            // get hours of worked
            // Calculate the difference in hours
            $hour_worked = $attendance_timeIn->diffInHours($timeOut);


            $total_salary_for_today = ($salary_per_hour * $hour_worked) - $minute_late;
            // if the total salary is less than 0, set it to 0
            if ($total_salary_for_today < 0) {
                $total_salary_for_today = 0;
            }

            // dd($total_salary_for_today, $salary_per_hour, $hour_worked, $minute_late, $subTotal, $salary_grade, $not_worked_hour,$status);
            //salary per attendance

            $status = $attendance->status . '/' . $status;
            $filePath = $path . $fileName;
            $attendance->update([
                'status' => $status,
                'time_out' => now(),
                'salary' => $total_salary_for_today,
                'time_out_image' => $filePath,
            ]);
        }
        // Save the image using Laravel's Storage facade

        Storage::disk('public')->put($filePath, $image_base64);
        return $status;
    }




    public function store(Request $request)
    {
        // dd($request->all());
        // check if the time is 10 am
        if (now()->format('H:i:s') >= '10:00:00') {
            return redirect()->back()->with('error', 'Attendance time is over!');
        }
        $request->validate([
            'employee_no' => 'required|exists:employees,emp_no',
            'image' => 'required',
        ]);
        
        $employee = Employee::with('attendances')->where('emp_no', $request->input('employee_no'))->first();
        // Check if the employee has attendance for the current date
        $existingAttendance = $employee->attendances()->whereDate('created_at', now())->first();

        if (!$existingAttendance) {
            // Create a new attendance record only if it doesn't exist for the current date
            $status = $this->checkStatus(true, $request->get('image'), null, $employee);
            return redirect()->back()->with('success', 'Attendance recorded successfully!');
        }

        return redirect()->back()->with('error', 'Attendance already recorded for the day!');
    }
    public function update(Request $request, $id)
    {
        // dd($request->all(), $id);
        $attendance = Attendance::find($id);
        $this->checkStatus(false, $request->get('image'), $attendance);
        return redirect()->back()->with('success', 'Attendance updated successfully!');
    }

    public function create()
    {
        // Retrieve attendance history records and pass them to the view
        $attendanceHistory = Attendance::with('employee')->orderBy('created_at', 'desc')->get();
        return view('attendances.history', compact('attendanceHistory'));
    }
    public function history()
    {
        // Retrieve distinct creation dates from the Attendance records
        $attendances = Attendance::selectRaw('DATE(created_at) as created_at')->distinct()->get();

    
        return view('attendances.history', compact('attendances'));
    }
    
    public function historyShow($date)
    {
        // get all dates in attendance and there shuld be no duplicate date
        $attendances = Attendance::with('employee')->whereDate('created_at', $date)->get();
        return view('attendances.show', compact('attendances','date'));
    }
}
