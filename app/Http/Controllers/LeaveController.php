<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeLeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $status)
    {
        return view('leaves.index', [
            'leave_requests' => EmployeeLeaveRequest::where('status', $status)->get(),
            'status' => $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Employee $employee)
    {
        return view('leaves.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $status)
    {
        return view('leaves.index', [
            'leave_requests' => EmployeeLeaveRequest::where('status', $status)->get(),
            'status' => $status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeLeaveRequest $leave_request)
    {
        $statuses = [
            'accepted',
            'rejected',
        ];
        return view('leaves.edit', ['statuses' => $statuses, 'leave_request' => $leave_request]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeLeaveRequest $leave_request)
    {
        try {
            $request->validate(['status' => 'required']);
            if ($request->status == 'accepted') {
                $leave_request->employee->data->update(['sick_leave_points' => ($leave_request->employee->data->sick_leave_points - (1.25 * $leave_request->days))]);

                $this->takeAttendance($leave_request, getDatesBetween($leave_request->start, $leave_request->end, true));
            }
            $leave_request->update(['status' => $request->status]);
            return redirect()->route('leave-requests.index', ['status' => $request->status])->with('success', 'Successfully updated leave request.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }




    public function takeAttendance($leave_request, $dates)
    {
        $salary_grade = $leave_request->employee->data->monthly_salary;
        $salary = $this->calculateSalary($salary_grade, $leave_request->employee->data->category);

        foreach ($dates as $key => $date) {
            $timeIn = $date . ' 08:00:00'; // Combine date with time in
            $timeOut = $date . ' 17:00:00'; // Combine date with time out
            Attendance::create([
                'employee_id' => $leave_request->employee->id,
                'time_in_status' => 'On-time',
                'time_in' => $timeIn,
                'time_out_status' => 'Time-out',
                'time_out' => $timeOut,
                'hours' => 8,
                'salary' =>   $salary,
                'type' =>   $leave_request->type,
                'isPresent' => 1,
            ]);
        }
    }
    public function calculateSalary($salaryGrade, $category)
    {
        if ($category->category_code == "JO") {
            return $salaryGrade;
        }
        if ($category->category_code == "COS") {
            return $salaryGrade / 22;
        }
        $salaryPerHour = ($salaryGrade / 22) / 8;
        return max(0, $salaryPerHour); // Ensure non-negative
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
