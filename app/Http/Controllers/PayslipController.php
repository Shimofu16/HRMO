<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class PayslipController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('payslips.index', compact('departments'));
    }
    public function show($department_id, $payroll)
    {
        $department = Department::find($department_id);
        $payroll = json_decode(urldecode($payroll), true);
        $employees = Employee::with('data')->whereHas('data', function ($query) use ($department_id) {
            $query->where('department_id', $department_id);
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
