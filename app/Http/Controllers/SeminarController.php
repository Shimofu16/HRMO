<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Seminar;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('attendances.seminar.index', [
            'seminars' => Seminar::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendances.seminar.create', [

            'departments' => Department::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'type' => 'required',
                'departments' => 'required',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required',
                'letter' => 'required|file|mimes:pdf,docx',
            ]);

            if ($request->hasFile('letter')) {

                $file_name = md5($request->letter . microtime()) . '.' . $request->letter->extension();
                $request->letter->storeAs('public/seminar', $file_name);

                Seminar::create([
                    'name' => $request->name,
                    'location' => $request->location,
                    'type' => $request->type,
                    'departments' => $request->departments,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'reason' => $request->reason,
                    'letter' => $file_name,
                ]);
                createActivity('Create Official business', 'Created official business ' .$request->name . '.', request()->getClientIp(true));
                return redirect()->route('seminars.index')->with('success', 'Successfully Created Seminar ' . $request->name);
            }
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($seminar_id)
    {
        $seminar = Seminar::find($seminar_id);
        $attendances = $seminar->attendances()->get();
        $employees = Employee::with('seminarAttendances', 'attendances')
            ->whereHas('data', function ($query) use ($seminar) {
                $query->whereIn('department_id', $seminar->departments);
            })
            ->whereDoesntHave('attendances', function ($query) use ($seminar) {
                $query
                    ->whereBetween('time_in', [$seminar->start_date, $seminar->end_date]);
            });

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
        // dd($employees);
        foreach ($employees as $key => $employee) {
            $start = Carbon::parse($seminar->start_date);
            $end = Carbon::parse($seminar->end_date);
            $salary_grade = $employee->data->monthly_salary;
            $salary = $this->calculateSalary($salary_grade, $employee->data->category);
            $employee->seminarAttendances()->create([
                'seminar_id' => $seminar->id,
                'salary' => $salary
            ]);
            for ($day = $start; $day->lte($end); $day = $day->addDay()) {

                $timeIn = date('Y-m-d', strtotime($day)) . ' 08:00:00'; // Combine date with time in
                $timeOut = date('Y-m-d', strtotime($day)) . ' 17:00:00'; // Combine date with time out
                Attendance::create([
                    'employee_id' => $employee->id,
                    'time_in_status' => 'On-time',
                    'time_in' => $timeIn,
                    'time_out_status' => 'Time-out',
                    'time_out' => $timeOut,
                    'hours' => 8,
                    'salary' =>   $salary,
                    'type' =>   $seminar->type,
                    'isPresent' => 1,
                ]);
            }
        }
        // $this->takeAttendance($seminar->time_start, $seminar->time_end, $employees, $seminar);
        createActivity('Create Official Business Attendance', 'Created Official Business Attendance for employees:' . count($employees) . '.', request()->getClientIp(true));
        return back()->with('success', 'Successfully Created Attendance');
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


    public function download($seminar_id)
    {
        $seminar = Seminar::find($seminar_id);
        // Assuming you have a 'letter' attribute in your Seminar model
        $filePath = storage_path('app/public/seminar/' . $seminar->letter);
        return response()->download($filePath);
    }
}
