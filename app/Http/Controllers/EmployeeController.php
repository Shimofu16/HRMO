<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Category;
use App\Models\Designation;
use App\Models\SalaryGrade;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\EmployeeAllowance;
use App\Models\EmployeeDeduction;
use App\Models\EmployeeSickLeave;
use App\Models\Loan;
use App\Models\Schedule;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index($filter_by = null, $filter_id = null)
    {

        $employees = Employee::query()
            ->with('data')
            ->orderBy('last_name', 'asc');
        $department = null;
        $category = null;
        $departments = Department::all();
        $categories = Category::all();
        if ($filter_by == "department") {
            $employees->whereHas('data', function ($query) use ($filter_id) {
                $query->where('department_id', $filter_id);
            });
        }
        if ($filter_by == "category") {
            $employees->whereHas('data', function ($query) use ($filter_id) {
                $query->where('category_id', $filter_id);
            });
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
        // dd(
        //     $request->all(),
        // );
        // dd(empty($request->input('amounts')) ? $request->input('selected_loan_amounts') : $request->input('amounts'),$request->input('amounts'));
        // Find the department
        $department = Department::find($request->department_id);
        $isJOSelected = $request->isJOSelected;

        // Calculate employee department count and employee count
        // $employee_department_count = $department->employees()->count() + 1;
        // $employee_count = Employee::count() + 1;
        // $latest_employee_ordinance_number = Employee::latest()->first();

        // Generate employee code
        // $employee_number = "{$department->dep_code}-{$employee_department_count}{$employee_count}";
        // $ordinance_number = ($latest_employee_ordinance_number) ? $latest_employee_ordinance_number->ordinance_number + 1 : $employee_count;
        $employee_number = $request->employee_number;
        $ordinance_number = $request->ordinance_number;
        $first_name = $request->first_name;
        $middle_name = $request->middle_name;
        $last_name = $request->last_name;
        $sick_leave_points = ($request->sick_leave_points) ? $request->sick_leave_points : 1.25;
        $department_id = $request->department_id;
        $designation_id = $request->designation_id;
        $category_id = $request->category_id;
        $allowances = $request->allowances;
        $deductions = $request->deductions;
        // dd($ordinance_number);

        // Create a new employee instance
        $employee = Employee::create([
            'employee_number' => $employee_number,
            'ordinance_number' => $ordinance_number,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
        ]);

        // Handle employee data
        if ($isJOSelected) {
            $level_id = $request->level_id;
            $employee->data()->create([
                'department_id' => $department_id,
                'designation_id' => $designation_id,
                'category_id' => $category_id,
                'level_id' => $level_id,
            ]);
        } else {
            $salary_grade_id = $request->salary_grade_id;
            $salary_grade_step = $request->salary_grade_step;
            $employee->data()->create([
                'department_id' => $department_id,
                'designation_id' => $designation_id,
                'category_id' => $category_id,
                'salary_grade_id' => $salary_grade_id,
                'salary_grade_step' => $salary_grade_step,
                'sick_leave_points' => $sick_leave_points,
            ]);
            // Handle allowances

            if ($allowances) {
                foreach ($allowances as $value) {
                    $employee->allowances()->create(['allowance_id' => $value]);
                }
            }

            // Handle deductions
            foreach ($deductions as $value) {
                $employee->deductions()->create(['deduction_id' => $value]);
            }

            $selected_loans = $request->only(['selected_loan_ids', 'amounts', 'durations', 'ranges']);

            // Ensure all arrays have the same length
            if ($selected_loans) {
                $loansData = array_map(function ($loanId, $amount, $duration, $range) use ($employee) {
                    return [
                        'loan_id' => $loanId,
                        'amount' => $amount,
                        'duration' => $duration,
                        'range' => $range,
                    ];
                }, $selected_loans['selected_loan_ids'], $selected_loans['amounts'], $selected_loans['durations'], $selected_loans['ranges']);

                // Create loans for the employee
                $employee->loans()->createMany($loansData);
            }
        }




        // Create activity
        createActivity('Create Employee', 'Employee ' . $employee->full_name . ' was created.', request()->getClientIp(true));

        // Redirect to the index page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }



    /**
     * Display the specified employee.
     */
    public function show($id)
    {
        $employee = Employee::with('data')->find($id);
        // dd($employee->data->salary_grade_id);
        return view('employees.show', compact('employee'));
    }


    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {

        return view('employees.edit', ['employee' => $employee]);
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


        // Handle deductions
        $deductions = $request->input('deduction');
        foreach ($deductions as $value) {
            $employee->deductions()->create(['deduction_id' => $value]);
        }
        // Handle allowances
        $allowances = $request->input('allowance');
        foreach ($allowances as $value) {
            $employee->allowances()->create(['allowance_id' => $value]);
        }

        // Handle sick leave
        $sick_leave = $request->input('sick_leave');
        $employee->sickLeave()->update(['points' => $sick_leave]);

        // Handle loans




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
        $employee->attendances()->delete();

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function dtr(Employee $employee)
    {
        return view('employees.dtr.index', [
            'employee' => $employee
        ]);
    }
    public function payslip(Employee $employee)
    {
        return view('employees.payslip.index', [
            'employee' => $employee
        ]);
    }
}
