<?php

namespace App\Http\Controllers;

use App\Imports\AttendanceImport;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index($filter_by = null, $filter_id = null)
    {
        $attendances = Attendance::query()->with('employee')->whereDate('time_in', now());
        if ($filter_by == "department") {
            $attendances->whereHas('employee.data', function ($query) use ($filter_id) {
                $query->where('department_id', $filter_id);
            });
        }
        if ($filter_by == "date") {
            $attendances->whereHas('employee.data', function ($query) use ($filter_id) {
                $query->where('department_id', $filter_id);
            });
        }

        $employees = Employee::all();
        $departments = Department::all();
        $attendances = $attendances->get();

        return view('attendances.index', compact('attendances', 'employees', 'departments'));
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
        $existingAttendance = $employee->attendances()->whereDate('time_in', now())->first();

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
        $attendanceHistory = Attendance::with('employee')->where('isPresent', 1)->orderBy('created_at', 'desc')->get();
        return view('attendances.history', compact('attendanceHistory'));
    }
    public function history()
    {
        // Retrieve distinct creation dates from the Attendance records and format it desc
        $attendances = Attendance::selectRaw('DATE(time_in) as date')->where('isPresent', 1)->distinct()->orderBy('date', 'desc')->get();

        return view('attendances.history', compact('attendances'));
    }

    public function historyShow($date)
    {
        // get all dates in attendance and there shuld be no duplicate date
        $attendances = Attendance::with('employee')->whereDate('time_in', $date)->get();

        return view('attendances.show', compact('attendances', 'date'));
    }
    public function uploadAttendance(Request $request)
    {
        $request->validate([
            'attendance' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new AttendanceImport, $request->file('attendance'));

            return back()->with('success', 'Attendance data imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}