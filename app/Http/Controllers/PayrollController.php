<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
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
    public function index()
    {
        // Retrieve all payroll records from the database
        $payrolls = Payroll::all();

        $departments = Department::all();
        // Other code to retrieve the payrolls

        // Pass the payroll records to the view
        return view('payrolls.index', compact('departments', 'payrolls'));

    }

    /**
     * Show the form for creating a new payroll record.
     */
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
    public function show(Payroll $payroll)
    {
        $employees = Employee::all();

        $allowances = Allowance::all();

        $sgrades = Sgrade::all();

        $departments = Department::all();

        // Pass the payroll record to the view
        return view('payrolls.show', compact('payroll', 'employees', 'allowances', 'sgrades', 'departments'));
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
