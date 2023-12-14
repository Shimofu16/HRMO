<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class PayslipController extends Controller
{
    public function index(){
        $departments = Department::all();
        return view('payslips.index', compact('departments'));
    }
    public function show($department_id, $payroll)
    {
        $department = Department::find($department_id);
        $payroll = json_decode(urldecode($payroll), true);
        $employees = $department->employees;
        // seperate the filter 1-15
        $filter = explode('-', $payroll['date_from_to']);
        $from = Carbon::create(date('Y'), date('m'), $filter[0]);
        $day = $filter[1];
        // convert month to number
        $month = Carbon::parse($payroll['month'])->month;
        $year = $payroll['year'];

        if (!checkdate($month, $day, $year)) {
            $day = date('t', mktime(0, 0, 0, $month, 1, $year)); // get last day of the month
        }

        $to = Carbon::create($year, $month, $day);

        $filter = [
            'from' => date('m/d/Y', strtotime($from)),
            'to' => date('m/d/Y', strtotime($to)),
        ];

        createActivity('Create Payslip', 'Generate Payslip for '. $department->dep_code, request()->getClientIp(true));

        $file_name = $department->dep_code.'-Payslip-'.$from->format('m-d-Y').'-'.$to->format('m-d-Y').'.pdf';
        // return view('downloads.payslips', compact('department', 'employees', 'filter'));
        $pdf = PDF::loadView('downloads.payslips', [
            'department'  => $department,
            'employees' => $employees,
            'filter' => $filter,
            'payroll' => $payroll,
        ]);

        return $pdf->download($file_name);
    }
}
