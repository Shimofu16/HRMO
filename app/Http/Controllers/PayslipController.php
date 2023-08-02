<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;

use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function index()
    {
        // Retrieve all employees from the database
        $employees = Employee::all();

        $payrolls = Payroll::all();

        // Pass the employees to the view
        return view('payslips.index', compact('employees','payrolls'));
    }
}
