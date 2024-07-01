<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
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
        $isTodayHoliday = $this->checkIfHoliday();
        return view('attendances.employees.index', compact('employees', 'isTodayHoliday'));
    }
    private function checkIfHoliday()
    {
        return  Holiday::whereDay('date', Carbon::now()->format('d'))
            ->whereMonth('date', Carbon::now()->format('m'))
            ->exists();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'employee_number' => 'required|exists:employees,employee_number',
            // 'image' => 'required',
            'type' => 'required',
        ]);

        //Get isTimeIn
        $isTimeIn = $request->input('type')  == 1;

        // Process image data
        // $image = $request->input('image');
        // $image_parts = explode(";base64,", $image);
        // $image_base64 = base64_decode(end($image_parts));

        // Get employee details
        $employee = Employee::with('attendances')
            ->where('employee_number', $request->employee_number)
            ->first();

        // Check if it's Saturday (6) or Sunday (0)
        if (Carbon::now()->isWeekend() && $employee->data->category->category_code != 'JO') {
            return redirect()->back()->with('error', 'Only JO is allowed to attendance every weekend');
        }

        // Generate file name and path
        // $fileName = uniqid() . ' Time ' . ($isTimeIn ? 'in' : 'out') . '.png';
        // $path = 'uploads/attendance/' . $employee->full_name . '/';
        // $filePath = $path . $fileName;


        // Check timing conditions
        if ($isTimeIn) {
            // check if the current time is 1pm or later
            if (Carbon::now()->format('H') >= 13) {
                // Redirect with error message
                return redirect()->back()->with('error', 'You can only time in before 1 pm!');
            }

            // Check if the employee has already timed in for the day
            $existingTimeIn = $employee->attendances()
                ->whereDate('time_in', now())
                ->whereNull('time_out') // Check if the employee has not timed out yet
                ->first();

            if ($existingTimeIn) {
                // Employee already timed in, show error message
                return redirect()->back()->with('error', 'Attendance already recorded for the day!');
            }

            // Take attendance for time in and record the details
            $this->takeAttendance($isTimeIn, $employee);

            // Redirect with success message
            return redirect()->back()->with('success', 'Attendance recorded successfully!');
        } else {

            // Check if the employee has already timed out for the day
            $existingTimeOut = $employee->attendances()
                ->whereDate('time_in', now())
                ->whereNotNull('time_in') // Check if the employee has already timed in
                ->whereNotNull('time_out') // Check if the employee has already timed out
                ->first();
            // Check if the employee has timed in for the day
            $existingTimeIn = $employee->attendances()
                ->whereDate('time_in', now())
                ->whereNotNull('time_in')
                ->whereNull('time_out')
                ->first();

            if ($existingTimeOut) {
                // Employee already timed out, show error message
                return redirect()->back()->with('error', 'You have already timed out for today!');
            }


            if (!$existingTimeIn) {
                // Employee has not timed in, show error message
                return redirect()->back()->with('error', 'You have not timed in for today!');
            }

            // Update attendance for time out and record the details
            $this->takeAttendance($isTimeIn, $employee);

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
    private function takeAttendance($isTimeIn, $employee)
    {
        $status = '';
        $timezone = 'Asia/Manila'; // Set the timezone to the Philippines

        Carbon::setLocale('en'); // Set the locale for Carbon if needed
        Carbon::setToStringFormat('Y-m-d H:i:s'); // Set the string format for Carbon objects if needed

        $now = Carbon::now($timezone);
        $current_time = $now->format('H:i:s');
        $timeIn = '08:00:00'; // 8am
        $defaultTimeIn = Carbon::parse($timeIn);
        $tenAMThreshold = '10:00:00'; // 10:00am
        $timeOut = '17:00:00'; // 5pm
        $deduction =  0;

        if ($isTimeIn) {
            // Check if employee is on time, half-day or late
            if ($current_time < $timeIn || $current_time <= $timeIn) {
                $status = 'On-time';
            } elseif ($current_time >= $tenAMThreshold) {
                $status = 'Half-Day';
                $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time));
                $deduction = getLateByMinutes($minute_late);
            } elseif ($current_time > $timeIn) {
                $status = 'Late';
                $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time));
                $deduction = getLateByMinutes($minute_late);
            }
            if ($employee->data->category->category_code == "JO" || $employee->data->sick_leave_points == 0) {
                $deduction = 0;
            }

            // Create attendance record for time in
            Attendance::create([
                'employee_id' => $employee->id,
                'time_in_status' => $status,
                'time_in' => $now,
                'time_in_deduction' => $deduction,
            ]);
        } else {

            $attendance = $employee->attendances()->whereDate('time_in', Carbon::today())->first();
            $salary_grade = $employee->data->monthly_salary;
            $results = calculateSalary($salary_grade, $employee, $attendance, $timeIn, $timeOut, $current_time, $employee->data->category->category_code == "JO");

            $status = $results['status'];
            $total_salary_for_today = $results['salary'];
            $hours = $results['hour_worked'];
            $time_out_deduction = $results['deduction'];

            // Update the attendance record
            $attendance->update([
                'time_out_status' => $status,
                'time_out' => $now,
                'hours' => $hours,
                'salary' => $total_salary_for_today,
                'isPresent' => 1,
                'time_out_deduction' => $time_out_deduction,
            ]);
        }

        // Save the image using Laravel's Storage facade
        // Storage::disk('public')->put($filePath, $image);
        return $status;
    }
  
    private function computeSickLeave($sick_leave, $minute_late)
    {
        $sick_leave_left = 0;

        // Compute the sick leave deduction per minute
        $sick_leave_left = $sick_leave - $this->getLateByMinutes($minute_late);

        // check if sick_leave_left is less than 0
        if ($sick_leave_left < 0) {
            $sick_leave_left = 0;
        }

        return $sick_leave_left;
    }
    private function getLateByMinutes($minute_late)
    {
        $equivalentMinutes = [
            1 => 0.002, 2 => 0.004, 3 => 0.006, 4 => 0.008, 5 => 0.010,
            6 => 0.012, 7 => 0.014, 8 => 0.017, 9 => 0.019, 10 => 0.021,
            11 => 0.023, 12 => 0.025, 13 => 0.027, 14 => 0.029, 15 => 0.031,
            16 => 0.033, 17 => 0.035, 18 => 0.037, 19 => 0.040, 20 => 0.042,
            21 => 0.044, 22 => 0.046, 23 => 0.048, 24 => 0.050, 25 => 0.052,
            26 => 0.054, 27 => 0.056, 28 => 0.058, 29 => 0.060, 30 => 0.062,
            31 => 0.065, 32 => 0.067, 33 => 0.069, 34 => 0.071, 35 => 0.073,
            36 => 0.075, 37 => 0.077, 38 => 0.079, 39 => 0.081, 40 => 0.083,
            41 => 0.085, 42 => 0.087, 43 => 0.090, 44 => 0.092, 45 => 0.094,
            46 => 0.096, 47 => 0.098, 48 => 0.100, 49 => 0.102, 50 => 0.104,
            51 => 0.106, 52 => 0.108, 53 => 0.110, 54 => 0.112, 55 => 0.114,
            56 => 0.117, 57 => 0.119, 58 => 0.121, 59 => 0.123, 60 => 0.125
        ];
        if (array_key_exists($minute_late, $equivalentMinutes)) {
            return $equivalentMinutes[$minute_late];
        } else {
            return 0;
        }
    }

    private function calculateSalary($salaryGrade, $employee, $attendance, $timeIn, $timeOut, $currentTime, $isJO)
    {
        // Default working days and hours
        $workingDays = 15;
        $requiredHoursWork = 8;

        // Carbon instances for attendance and defaults
        $attendanceTimeIn = Carbon::parse($attendance->time_in);
        $attendanceTimeOut = Carbon::parse($currentTime);
        $defaultTimeIn = Carbon::parse($timeIn);
        $defaultTimeOut = Carbon::parse($timeOut);

        // Calculate hours worked, handling negative values and exceeding 8 hours
        $hourWorked = $defaultTimeIn->diffInHours($attendanceTimeOut, true) - 1;
        $hourWorked = max(0, min($hourWorked, $requiredHoursWork)); // Ensure 0-8 hours

        // Calculate minutes late
        $minutesLate = $defaultTimeIn->diffInMinutes($attendanceTimeIn);

        // Calculate salary per hour (applicable only for non-JO employees)
        if (!$isJO) {
            $salaryPerHour = ($salaryGrade / 22) / $requiredHoursWork;

            // Sick leave handling (requires a `computeSickLeave` function)
            $sickLeave = $employee->data->sick_leave_points;
            if ($sickLeave > 0) {
                $sickLeave = $this->computeSickLeave($sickLeave, $minutesLate);
            }
        }

        // Determine attendance status and adjust salary (if applicable)
        $status = ($currentTime < $timeOut) ? 'Under-time' : 'Time-out';
        if (!$isJO && $currentTime < $timeOut) {
            $notWorkedHour = $defaultTimeOut->diffInHours($currentTime);
            $salaryPerHour = $salaryPerHour - $notWorkedHour;

            $sickLeave = $sickLeave - ($notWorkedHour * 1.25);
            if ($sickLeave < 0) {
                $sickLeave = 0;
            }
        }

        // Calculate total salary for the day (applicable only for non-JO employees)
        if (!$isJO) {
            $totalSalaryForToday = max(0, $salaryPerHour * $hourWorked); // Ensure non-negative
            if ($attendance->time_in_status === 'Late') {
                $totalSalaryForToday = $totalSalaryForToday - ($sickLeave === 0) ? $this->getLateByMinutes($minutesLate) : 0;
            }
            $employee->data->update(['sick_leave_points' => $sickLeave]);
        } else {
            if ($attendance->time_in_status === 'Half-Day') {
                $totalSalaryForToday = $salaryGrade / 2;
            } else {
                $totalSalaryForToday = $salaryGrade;
            }
        }

        return [
            'salary' => $totalSalaryForToday,
            'status' => $status,
            'hour_worked' => $hourWorked,
        ];
    }
}