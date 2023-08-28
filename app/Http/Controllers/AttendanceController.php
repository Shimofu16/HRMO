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
