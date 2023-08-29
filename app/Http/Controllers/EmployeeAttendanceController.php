<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('attendances.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    private function takeAttendance($isTimeIn, $image, $employee, $filePath)
    {
        $status = '';
        $timezone = 'Asia/Manila'; // Set the timezone to the Philippines

        Carbon::setLocale('en'); // Set the locale for Carbon if needed
        Carbon::setToStringFormat('Y-m-d H:i:s'); // Set the string format for Carbon objects if needed

        $now = Carbon::now($timezone);
        $current_time = $now->format('H:i:s');
        $timeIn = '08:00:00'; // 8am
        $lateThreshold = '08:10:00'; // 8:10am
        $tenAMThreshold = '10:00:00'; // 10:00am
        $timeOut = '17:00:00'; // 5pm

        if ($isTimeIn ==  1) {
            // Check if employee is on time, half-day or late
            if ($current_time >= $timeIn && $current_time <= $lateThreshold) {
                $status = 'On-Time';
            } elseif ($current_time > $tenAMThreshold) {
                $status = 'Half-Day';
            } elseif ($current_time > $lateThreshold) {
                $status = 'Late';
            }

            // Create attendance record for time in
            Attendance::create([
                'employee_id' => $employee->id,
                'status' => $status,
                'time_in' => $now,
                'time_in_image' => $filePath,
            ]);
        } else {

            $attendance = $employee->attendances()->whereDate('created_at', Carbon::today())->first();

            $salary_grade = $employee->sgrade->sg_amount;
            $working_days = 15;
            $required_hours_work = 8;
            $subTotal = (($salary_grade / 2) / $working_days) / $required_hours_work;

            $defaultTimeIn = Carbon::parse($timeIn);
            $defaultTimeOut = Carbon::parse($timeOut);
            $attendanceTimeIn = Carbon::parse($attendance->time_in);

            // Calculate the difference in hours
            $hour_worked = $attendanceTimeIn->diffInHours($defaultTimeOut);

            // Calculate the difference in minutes between the attendance time in and the default time in
            $minute_late = $defaultTimeIn->diffInMinutes($attendance->time_in);

            // Check if the current time is less than the time out
            if ($current_time <= $timeOut) {
                $status = 'Under-time';
                // Calculate the difference in minutes between the default time out and the current time
                $diff = $defaultTimeOut->diffInMinutes($current_time);
                $not_worked_hour = $diff / 60;
                $salary_per_hour = $subTotal - $not_worked_hour;
            } else {
                $salary_per_hour = $subTotal;
            }

            // Calculate the total salary for the day
            $total_salary_for_today = ($salary_per_hour * $hour_worked) - $minute_late;

            // Ensure that the total salary is not negative
            if ($total_salary_for_today < 0) {
                $total_salary_for_today = 0;
            }

            // Update attendance record
            $status = $attendance->status . '/' . $status;

            $attendance->update([
                'status' => $status,
                'time_out' => $now,
                'salary' => $total_salary_for_today,
                'time_out_image' => $filePath,
            ]);
        }
        // Save the image using Laravel's Storage facade

        Storage::disk('public')->put($filePath, $image);
        return $status;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all(),$isTimeIn);
        $request->validate([
            'employee_no' => 'required|exists:employees,emp_no',
            'image' => 'required',
            'type' => 'required',
        ]);

        //Get isTimeIn
        $isTimeIn = $request->input('type');

        // Process image data
        $image = $request->input('image');
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode(end($image_parts));

        // Get employee details
        $employee = Employee::with('attendances')->where('emp_no', $request->input('employee_no'))->first();

        // Generate file name and path
        $fileName = uniqid() . 'Time ' . ($isTimeIn == 1 ? 'in' : 'ut') . '.png';
        $path = 'uploads/attendance/' . $employee->name . '/';
        $filePath = $path . $fileName;


        // Check timing conditions
        if ($isTimeIn == 1) {
            // Check if the employee has already timed in for the day
            $existingTimeIn = $employee->attendances()
                ->whereDate('created_at', now())
                ->whereNull('time_out')
                ->first();

            if ($existingTimeIn) {
                // Employee already timed in, show error message
                return redirect()->back()->with('error', 'Attendance already recorded for the day!');
            }

            // Take attendance for time in and record the details
            $this->takeAttendance($isTimeIn, $image_base64, $employee, $filePath);

            // Redirect with success message
            return redirect()->back()->with('success', 'Attendance recorded successfully!');
        } else {
            // Check if the employee has already timed out for the day
            $existingTimeOut = $employee->attendances()
                ->whereDate('created_at', now())
                ->whereNotNull('time_in')
                ->whereNotNull('time_out')
                ->first();

            if ($existingTimeOut) {
                // Employee already timed out, show error message
                return redirect()->back()->with('error', 'You have already timed out for today!');
            }

            // Check if the employee has timed in for the day
            $existingTimeIn = $employee->attendances()
                ->whereDate('created_at', now())
                ->whereNotNull('time_in')
                ->whereNull('time_out')
                ->first();

            if (!$existingTimeIn) {
                // Employee has not timed in, show error message
                return redirect()->back()->with('error', 'You have not timed in for today!');
            }

            // Update attendance for time out and record the details
            $this->takeAttendance($isTimeIn, $image_base64, $employee, $filePath);

            // Redirect with success message
            return redirect()->back()->with('success', 'Attendance Updated successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
