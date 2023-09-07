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
    public function show($department_id, $filter)
    {
        $department = Department::find($department_id);
        $employees = $department->employees;
        // seperate the filter 1-15
        $filter = explode('-', $filter);
        $from = Carbon::create(date('Y'), date('m'), $filter[0]);
        $to = Carbon::create(date('Y'), date('m'), $filter[1]);
        $filter = [
            'from' => date('m/d/Y', strtotime($from)),
            'to' => date('m/d/Y', strtotime($to)),
        ];


        // return view('downloads.payslips', compact('department', 'employees', 'filter'));
        $pdf = PDF::loadView('downloads.payslips', [
            'department'  => $department,
            'employees' => $employees,
            'filter' => $filter,
        ]);

        return $pdf->download('payslips.pdf');
    }
}
