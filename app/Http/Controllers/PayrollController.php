<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Deduction;
use App\Models\Payroll;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\SalaryGrade;
use App\Models\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of payroll records.
     */
    public function index()
    {
        try {
            // dd($months, $payrolls);
            $departments = Department::all();
            // Other code to retrieve the payrolls

            // Pass the payroll records to the view
            // dd($payrolls);
            return view('payrolls.index', compact('departments'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new payroll record.
     */
    private function getPayroll($department, $months)
    {
        $payrolls = [];
        $fromTo = ['1-15', '16-31'];
        foreach ($months as $month) {
            foreach ($fromTo as $itemDay) {

                // Create a unique key for the payroll record
                $uniqueKey = "{$department->id}_{$month->month}_{$itemDay}";

                // Only create a new payroll record if it doesn't exist
                if (!isset($payrolls[$uniqueKey])) {
                    $payrolls[$uniqueKey] = [
                        'department_id' => $department->id,
                        'department' => $department->dep_name,
                        'month' => date('F', strtotime($month->earliest_time_in)),
                        'year' => date('Y', strtotime($month->earliest_time_in)),
                        'date_from_to' => $itemDay,
                        'date' => $month->earliest_time_in,
                    ];
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
    public function show(Department $department)
    {

        $months = Attendance::selectRaw('MONTH(time_in) as month, MIN(time_in) as earliest_time_in')
            ->where('isPresent', 1)
            ->whereYear('time_in', now()->format('Y'))
            ->groupByRaw('MONTH(time_in)')
            ->orderByRaw('MONTH(time_in)')
            ->get();
        // Fetch employees belonging to the department
        $employees = Employee::whereHas('data', function ($query) use ($department) {
            $query->where('department_id', $department->id);
        })->get();

        // Check if no employees found for the given department
        if ($employees->isEmpty()) {
            return back()->withErrors(['error' => 'No employees found for the selected department.']);
        }
        
        // Fetch signatures
        $signatures = Signature::all();

        // Check if no signatures are found
        if ($signatures->isEmpty()) {
            return back()->withErrors(['error' => 'No signatures available. Please set up the required signatures.']);
        }
        $payrolls = $this->getPayroll($department, $months);
        // Pass the payroll record to the view
        return view('payrolls.show', compact('payrolls', 'department'));
    }
    // public function dtr($id, $payroll)
    // {
    //     $payroll = json_decode(urldecode($payroll), true);
    //     $dates = explode('-', $payroll['date_from_to']);
    //     $from = $dates[0];
    //     $to = $dates[1];

    //     $employee = Employee::find($id);

    //     $data = attendanceCount($employee, $payroll, $from, $to);

    //     // Pass the payroll record to the view
    //     return view(
    //         'payrolls.dtr',
    //         [
    //             'employee' => $employee,
    //             'payroll' => $payroll,
    //             'present' => $data['present'],
    //             'absent' => $data['absent'],
    //             'late' => $data['late'],
    //             'under_time' => $data['under_time'],
    //             'total_man_hour' => $data['total_man_hour'],
    //             'attendances' => $data['attendances'],
    //         ]
    //     );
    // }
    public function generalPayslip($payroll)
    {
        try {
            // Decode and extract payroll data
            $payroll = json_decode(urldecode($payroll), true);
            $dates = explode('-', $payroll['date_from_to']);
            $from = $dates[0];
            $to = $dates[1];
            $department = Department::find($payroll['department_id']);

            // Filename and date title for display purposes
            $filename = "General Payroll - {$payroll['department']}";
            $dateTitle = "{$payroll['month']} {$payroll['date_from_to']}, {$payroll['year']}";

            // Fetch employees belonging to the department
            $employees = Employee::whereHas('data', function ($query) use ($payroll) {
                $query->where('department_id', $payroll['department_id']);
            })->get();

            // Check if no employees found for the given department
            if ($employees->isEmpty()) {
                return back()->withErrors(['error' => 'No employees found for the selected department.']);
            }

            // Fetch signatures
            $signatures = Signature::all();

            // Check if no signatures are found
            if ($signatures->isEmpty()) {
                return back()->withErrors(['error' => 'No signatures available. Please set up the required signatures.']);
            }

            // Pass the payroll record and other necessary data to the view
            return view(
                'payrolls.general-payslip.index',
                [
                    'filename' => $filename,
                    'dateTitle' => $dateTitle,
                    'payroll' => $payroll,
                    'from' => $from,
                    'to' => $to,
                    'department' => $department,
                    'loans' => Loan::all(),
                    'deductions' => Deduction::all(),
                    'signatures' => $signatures,
                    'employees' => $employees,
                ]
            );
        } catch (\Exception $e) {
            // Handle any exceptions
            return back()->withErrors(['error' => 'An error occurred while generating the payroll: ' . $e->getMessage()]);
        }
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

    public function payslip(Department $department, $payroll)
    {
        $payroll = json_decode(urldecode($payroll), true);
        $employees = Employee::with('data')->whereHas('data', function ($query) use ($department) {
            $query->where('department_id', $department->id);
        })
            ->get();

        // seperate the filter 1-15
        $filter = explode('-', $payroll['date_from_to']);
        $from = Carbon::create(date('Y'), date('m'), $filter[0]);
        $day = $filter[1];
        // convert month to number
        $month = Carbon::parse($payroll['month']);
        $year = $payroll['year'];

        if (!checkdate(date('m', strtotime($month)), $day, $year)) {
            $to = date('t', mktime(0, 0, 0, date('m', strtotime($month)), 1, $year)); // get last day of the month
        }

        $to = Carbon::create($year, $month->format('m'), $day);
        // $formattedMonth = date('F', strtotime($month));
        $period = "{$month->format('F')} {$payroll['date_from_to']}, {$year}";

        createActivity('Create Payslip', 'Generate Payslip for ' . $department->dep_code, request()->getClientIp(true));

        $file_name = $department->dep_code . '-Payslip-' . $from->format('m-d-Y') . '-' . $to->format('m-d-Y') . '.pdf';
        return view('downloads.payslips', [
            'department'  => $department,
            'employees' => $employees,
            'period' => $period,
            'payroll' => $payroll,
            'from' => $filter[0],
            'to' => $filter[1],
            'file_name' => $file_name,
            'allowances' => Allowance::all(),
            'deductions' => Deduction::all(),
            'loans' => Loan::all(),
        ]);
        // $pdf = PDF::loadView('downloads.payslips', [
        //     'department'  => $department,
        //     'employees' => $employees,
        //     'filter' => $filter,
        //     'payroll' => $payroll,
        // ])
        // ->setPaper('a4', 'landscape');

        // return $pdf
        //     ->stream($file_name);
    }
}
