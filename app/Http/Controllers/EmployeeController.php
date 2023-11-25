<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Category;
use App\Models\Designation;
use App\Models\Sgrade;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\EmployeeAllowance;
use App\Models\EmployeeDeduction;
use App\Models\EmployeeSickLeave;
use App\Models\Loan;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index($filter_by = null, $filter_id = null)
    {
        // Retrieve all employees from the database with their associated sgrade
        $employees = Employee::query()->orderBy('name', 'asc');
        $department = null;
        $category = null;
        $departments = Department::all();
        $categories = Category::all();
        if ($filter_by == "department") {
            $employees->where('department_id', $filter_id);
        }
        if ($filter_by == "category") {
            $employees->where('category_id', $filter_id);
        }

        // get all the employees
        $employees = $employees->get();
        return view('employees.index', compact('employees', 'departments', 'categories', 'department', 'category'));
    }


    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in the database.
     */
    public function store(Request $request)
    {
        // dd(empty($request->input('amounts')) ? $request->input('selected_loan_amounts') : $request->input('amounts'),$request->input('amounts'));
        // Find the department
        $department = Department::find($request->input('department_id'));

        // Calculate employee department count and employee count
        $employee_department_count = $department->employees()->count() + 1;
        $employee_count = Employee::count() + 1;

        // Generate employee code
        $employee_code = $department->dep_code . '-' . $employee_department_count . '' . $employee_count;

        // Create a new employee instance
        $employee = Employee::create([
            'emp_no' => $employee_code,
            'oinumber' => $request->input('oinumber'),
            'sgrade_id' => $request->input('sgrade_id'),
            'name' => $request->input('name'),
            'department_id' => $request->input('department_id'),
            'designation_id' => $request->input('designation_id'),
            'category_id' => $request->input('category_id'),
            'schedule_id' => $request->input('schedule_id'),
            'salary_grade_step_id' => $request->input('salary_grade_step_id'),
        ]);

        // Handle allowances
        $allowances = $request->input('allowance');
        if ($allowances) {
            foreach ($allowances as $value) {
                $employee->allowances()->create(['allowance_id' => $value]);
            }
        }

        // Handle deductions
        $deductions = $request->input('deduction');
        foreach ($deductions as $value) {
            $employee->deductions()->create(['deduction_id' => $value]);
        }

        // Handle sick leave
        $sick_leave = $request->input('sick_leave');
        $employee->sickLeave()->create([
            'points' => ($sick_leave) ? $sick_leave : 1.25
        ]);
        $selected_loan_ids = $request->input('selected_loan_ids');
        $selected_loan_amounts = empty($request->input('amounts')) ? $request->input('selected_loan_amounts') : $request->input('amounts');
        // combine this two to one array
        if ($selected_loan_ids && $selected_loan_amounts) {
            $loans_and_amounts = array_combine($selected_loan_ids, $selected_loan_amounts);
            foreach ($loans_and_amounts as $key => $value) {
                // Handle loans
                $employee->loans()->create([
                    'loan_id' => $key,
                    'amount' => $value,
                ]);
            }

        }

        // Create activity
        createActivity('Create Employee', 'Employee ' . $request->name . ' was created.', request()->getClientIp(true));

        // Redirect to the index page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }



    /**
     * Display the specified employee.
     */
    public function show(Request $request)
    {
        $employees = Employee::with('Sgrade');
        return view('employees.show', compact('employee'));
    }


    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $loans = Loan::all();

        $departments = Department::all();

        $categories = Category::all();

        $designations = Designation::all();

        $sgrades = Sgrade::all();

        $allowances = Allowance::all();

        $deductions = Deduction::all();

        return view('employees.edit', ['employee' => $employee, 'loans' => $loans, 'departments' => $departments, 'categories' => $categories, 'designations' => $designations, 'sgrades' => $sgrades, 'allowances' => $allowances, 'deductions' => $deductions]);
    }

    /**
     * Update the specified employee in the database.
     */
    public function update(Request $request, Employee $employee)
    {

        // dd($request->all());
        $employee->update([
            'department_id' => $request->input('department_id'),
            'designation_id' => $request->input('designation_id'),
            'category_id' => $request->input('category_id'),
            'sgrade_id' => $request->input('sgrade_id'),
        ]);
        $employee->allowances()->delete();
        $employee->deductions()->delete();

        $allowances = $request->input('allowance');
        $deductions = $request->input('deduction');

        // Handle deductions
        $deductions = $request->input('deduction');
        foreach ($deductions as $value) {
            $employee->deductions()->create(['deduction_id' => $value]);
        }

        // Handle sick leave
        $sick_leave = $request->input('sick_leave');
        $employee->sickLeave()->update(['points' => $sick_leave]);

        // Handle loans
        $employee->loans()->create(['loan_id' => $request->input('loan_id'), 'amount' => $request->input('loan_amount'),]);



        createActivity('Update Employee', 'Employee ' . $request->name . ' was updated.', request()->getClientIp(true));

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->allowances()->delete();
        $employee->deductions()->delete();

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
