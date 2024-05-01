<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
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
    public function create()
    {
        $types = [
            'vacation',
            'sick',
            'force',
        ];

        return view('leaves.create', [
            'types' => $types
        ]);
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

                $this->takeAttendance($leave_request->employee, $this->getDatesBetween($leave_request->start, $leave_request->end));
            }
            $leave_request->update(['status' => $request->status]);
            return redirect()->route('leave-requests.index', ['status' => $request->status])->with('success', 'Successfully updated leave request.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
    function getDatesBetween($startDate, $endDate)
    {
        $dates = [];
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $dates;
    }


    public function takeAttendance($employee, $dates)
    {
        if ($employee->data->category->category_code == "JO") {
            $salaryGrade = $employee->data->level->amount;
            $salary = $this->calculateSalary($salaryGrade, $employee, true);
        } else {
            $salaryGrade = $employee->data->salary_grade_step_amount;
            $salary = $this->calculateSalary($salaryGrade, $employee, false);
        }
        foreach ($dates as $key => $date) {
            $timeIn = $date . ' 08:00:00'; // Combine date with time in
            $timeOut = $date . ' 17:00:00'; // Combine date with time out
            Attendance::create([
                'employee_id' => $employee->id,
                'time_in_status' => 'On-time',
                'time_in' => $timeIn,
                'time_out_status' => 'Time-out',
                'time_out' => $timeOut,
                'hours' => 8,
                'salary' =>   $salary,
                'isPresent' => 1,
            ]);
        }
    }
    public function calculateSalary($salaryGrade, $employee, $isJO)
    {
        if ($isJO) {
            $totalSalaryForToday = $salaryGrade;
        } else {
            $salaryPerHour = ($salaryGrade / 2) / (15 * 8);
            $totalSalaryForToday = max(0, $salaryPerHour * 8); // Ensure non-negative
        }
        return    $totalSalaryForToday;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
