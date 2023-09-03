<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Payroll;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Sgrade;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of payroll records.
     */
    public function index($department_id = null)
    {
        try {
            // Retrieve all payroll records from the database
            // get all the departments
            $employee_departments = Department::query()->whereHas('employees')->distinct('dep_name');
            if ($department_id) {
                $employee_departments->where('id', $department_id);
            }
            $employee_departments = $employee_departments->get();

            // get all the months in attendance
            $months = Attendance::distinct('month')->get();
            $payrolls = $this->getPayroll($employee_departments, $months);
            // dd($payrolls, $employee_departments, $months);
            $departments = Department::all();
            // Other code to retrieve the payrolls

            // Pass the payroll records to the view
            return view('payrolls.index', compact('departments', 'payrolls'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new payroll record.
     */
    private function getPayroll($departments, $months)
    {
        $payrolls = [];
        $fromTo = ['1-15', '16-31'];
        foreach ($departments as $key => $department) {
            foreach ($months as $key => $month) {
                foreach ($fromTo as $key => $itemDay) {
                    $uniqueKey = "{$department->id}_{$month->month}_{$itemDay}";



                    if (!isset($payrolls[$uniqueKey])) {
                        $payrolls[$uniqueKey] = [
                            'department_id' => $department->id,
                            'department' => $department->dep_name,
                            'month' => date('F', strtotime($month->created_at)),
                            'year' => date('Y'),
                            'date_from_to' => $itemDay,
                        ];
                    }
                }
            }
        }
        return $payrolls;
    }

    public function create()
    {
        $departments = Department::all();

        return view('payrolls.create', compact('departments'));
    }

    /**
     * Store a newly created payroll record in the database.
     */
    public function store(Request $request)
    {
        $payroll = new Payroll([
            'pr_department' => $request->pr_department,
            'month' => $request->month,
            'year' => $request->year,
            'date_from_to' => $request->date_from_to,
        ]);
        $payroll->save();

        return redirect()->route('payrolls.index')->with('success', 'Payroll record created successfully.');
    }

    /**
     * Display the specified payroll record.
     */
    public function show($payroll)
    {
        $payroll = json_decode(urldecode($payroll), true);
        $employees = Department::find($payroll['department_id'])->employees;
        // Pass the payroll record to the view
        return view('payrolls.show', compact('payroll', 'employees'));
    }
    public function dtr($id, $payroll)
    {
        $payroll = json_decode(urldecode($payroll), true);
        $dates = explode('-', $payroll['date_from_to']);
        $from = $dates[0];
        $to = $dates[1];

        $employee = Employee::find($id);
        $presents = $employee->countAttendance('present', $payroll['month'], $payroll['year'], $from, $to);
        $absents = $employee->countAttendance('absent', $payroll['month'], $payroll['year'], $from, $to);
        $lates = $employee->countAttendance('late', $payroll['month'], $payroll['year'], $from, $to);
        $undertimes = $employee->countAttendance('undertime', $payroll['month'], $payroll['year'], $from, $to);
        $attendances = $employee->attendances;



        // Pass the payroll record to the view
        return view('payrolls.dtr', compact('employee', 'attendances', 'presents', 'absents', 'lates', 'undertimes','payroll'));
    }

    /**
     * Show the form for editing the specified payroll record.
     */
    public function edit(Payroll $payroll)
    {
        return view('payrolls.edit', compact('payroll'));
    }

    /**
     * Update the specified payroll record in the database.
     */
    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'pr_department' => 'required',
            'month' => 'required',
            'year' => 'required',
            'date_from_to' => 'required',
        ]);

        $payroll->update($request->all());

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll record updated successfully.');
    }

    /**
     * Remove the specified payroll record from storage.
     */
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll record deleted successfully.');
    }

    public function generateSlip(Payroll $payroll)
    {
        // Pass the payroll record to the view
        return view('payrolls.generateSlip', compact('payroll'));
    }
}
