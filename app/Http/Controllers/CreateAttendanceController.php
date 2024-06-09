<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreateAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendances.manual.create',[
            'employees' => Employee::with( 'attendances')
            ->whereDoesntHave('attendances', function ($query) {
                $query
                    ->whereDate('time_in', now()->format('Y-m-d'));
            })
            ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            $employee = Employee::find($request->employee_id);
            $now_time_in = Carbon::parse($request->start_time);
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
            if ($employee->data->category->category_code == "JO" || $employee->data->sick_leave_points == 0) {
                $time_in_deduction = 0;
            }

            // Create attendance record for time in
            $attendance =    Attendance::create([
                'employee_id' => $employee->id,
                'time_in_status' => $status,
                'time_in' => $now_time_in,
                'time_in_deduction' => $time_in_deduction,
            ]);
            $now_time_out = Carbon::parse($request->end_time);
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
            createActivity('Create Attendance', 'Created Attendance for employee ' .  $employee->full_name . '.', request()->getClientIp(true));
            return back()->with('success', 'Successfully created attendance');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
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
