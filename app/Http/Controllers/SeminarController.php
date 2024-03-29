<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Seminar;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('attendances.seminar.index', [
            'seminars' => Seminar::all(),
            'departments' => Department::all(),
        ]);
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
        Seminar::create([
            'name' => $request->name,
            'date' => $request->date,
            'departments' => $request->departments
        ]);
        return back()->with('success', 'Successfully Created Seminar ' . $request->name);
    }

    /**
     * Display the specified resource.
     */
    public function show($seminar_id)
    {
        $seminar = Seminar::find($seminar_id);
        $attendances = $seminar->attendances()->get();
        $employees = Employee::query()
            ->with('seminarAttendances')
            ->whereDoesntHave('seminarAttendances', function ($query) use ($seminar) {
                $query
                    ->whereDate('created_at', $seminar->date);
            });
        if ($seminar->departments[0] != 'All') {
            $employees->whereHas('data', function ($query) use ($seminar) {
                $query->whereIn('department_id', $seminar->departments);
            });
        }

        $employees = $employees->get();
        return view('attendances.seminar.show', compact('seminar', 'attendances', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seminar $seminar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seminar $seminar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seminar $seminar)
    {
        //
    }
    public function attendance($seminar_id, Request $request)
    {
        $seminar = Seminar::find($seminar_id);
        $employees = Employee::find($request->employees);
        foreach ($employees as $key => $employee) {
            $employee->seminarAttendances()->create([
                'seminar_id' => $seminar->id,
                'salary' => ((($employee->data->salary_grade_step_amount / 2) / 15) / 8)
            ]);
        }
        // $this->takeAttendance($seminar->time_start, $seminar->time_end, $employees, $seminar);
        return back()->with('success', 'Successfully Created Attendance');
    }

    public function payslip($employee_id)
    {
        $employee = Employee::withCount('seminarAttendances')->find($employee_id);

        $attendances = $employee->seminarAttendances();
        // dd($employee,$attendances);

        if ($employee->seminar_attendances_count > 0) {
            $file_name = "{$employee->full_name} - Seminar Payslip.pdf";
            $pdf = PDF::loadView('downloads.seminar', [
                'employee'  => $employee,
                'attendances' => $attendances->get(),
            ]);

            return $pdf->download($file_name);
        }
        return back()->with('error', 'The employee doesn`t have seminar attendance');
    }

    private function takeAttendance($time_in, $time_out, $employees, $seminar)
    {
        $attendanceTimeIn = Carbon::parse($time_in);
        $attendanceTimeOut = Carbon::parse($time_out);
        $hours_worked = $attendanceTimeIn->diffInHours($attendanceTimeOut);
        $total_salary_for_today = 0;
        $working_days = 15;
        $required_hours_work = 8;

        if ($hours_worked < 0) {
            $hours_worked = 0;
        }

        if ($hours_worked > 8) {
            $hours_worked = 8;
        }
        foreach ($employees as $key => $employee) {
            $salary_grade = $employee->salaryGradeStep->amount;
            $total_salary_for_today = (($salary_grade / 2) / $working_days) / $required_hours_work;
            Attendance::create([
                'employee_id' => $employee->id,
                'seminar_id' => $seminar->id,
                'time_in_status' => 'On-time',
                'time_in' => $attendanceTimeIn,
                'time_out_status' => 'Time-out',
                'time_out' => $attendanceTimeOut,
                'hours' => $hours_worked,
                'salary' => $total_salary_for_today,
                'isPresent' => 1,
            ]);
        }
    }
}
