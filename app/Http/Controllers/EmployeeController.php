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
        $departments = Department::all();

        $categories = Category::all();

        $designations = Designation::all();

        $schedules = Schedule::all();

        $sgrades = Sgrade::all();

        $allowances = Allowance::pluck('allowance_code', 'id');

        $mandatory_deductions = Deduction::where('deduction_type', 'Mandatory')->get();

        $non_mandatory_deductios = Deduction::where('deduction_type', 'Non-Mandatory')->get();

        return view('employees.create', compact('departments', 'categories', 'designations', 'schedules', 'sgrades', 'allowances', 'mandatory_deductions', 'non_mandatory_deductios'));
    }

    /**
     * Store a newly created employee in the database.
     */
    public function store(Request $request)
    {

        // try {
        // // Validate the input and store the employee
        // $validator = Validator::make($request->all(), [
        //     'emp_no' => 'required|string|max:255',
        //     'oinumber' => 'required|string|max:255',
        //     'sgrade' => 'required|string|max:255',
        //     'name' => 'required|string|max:255',
        //     'department' => 'required|string|max:255',
        //     'designation' => 'required|string|max:255',
        //     'category' => 'required|string|max:255',
        //     'allowance' => 'required|array',
        //     'deduction' => 'required|array',

        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        // dd($request->all());
        $department = Department::find($request->input('department_id'));
        $employee_department_count = $department->employees()->count() + 1;
        $employee_count = Employee::count() + 1;
        $employee_code = $department->dep_code . '-' . $employee_department_count . '' . $employee_count;
        // Create a new employee instance
        $employeeId = Employee::create([
            'emp_no' => $employee_code,
            'oinumber' => $request->input('oinumber'),
            'sgrade_id' => $request->input('sgrade_id'),
            'name' => $request->input('name'),
            'department_id' => $request->input('department_id'),
            'designation_id' => $request->input('designation_id'),
            'category_id' => $request->input('category_id'),
            'schedule_id' => $request->input('schedule_id'),
            'salary_grade_step_id' => $request->input('salary_grade_step_id'),
        ])->id;
        $allowances = $request->input('allowance');
        $deductions = $request->input('deduction');
        $sick_leave = $request->input('sick_leave');
        if ($allowances) {
            foreach ($allowances as $key => $value) {
                EmployeeAllowance::create([
                    'employee_id' => $employeeId,
                    'allowance_id' => $value,
                ]);
            }
        }
        foreach ($deductions as $key => $value) {
            EmployeeDeduction::create([
                'employee_id' => $employeeId,
                'deduction_id' => $value,
            ]);
        }
        EmployeeSickLeave::create([
            'employee_id' => $employeeId,
            'points' => ($sick_leave) ? $sick_leave : 1.25,
        ]);

        createActivity('Create Employee', 'Employee '. $request->name.' was created.', request()->getClientIp(true));
        // Redirect to the index page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
        // } catch (\Throwable $th) {
        //     // Handle the exception
        //     return redirect()->back()->with('error', 'An error occurred while saving the employee: ' . $th->getMessage());
        // }
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
        $departments = Department::all();

        $categories = Category::all();

        $designations = Designation::all();

        $sgrades = Sgrade::all();

        $allowances = Allowance::all();

        $deductions = Deduction::all();

        return view('employees.edit', ['employee' => $employee, 'departments' => $departments, 'categories' => $categories, 'designations' => $designations, 'sgrades' => $sgrades, 'allowances' => $allowances, 'deductions' => $deductions]);
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

        foreach ($allowances as $key => $value) {
            EmployeeAllowance::create([
                'employee_id' => $employee->id,
                'allowance_id' => $value,
            ]);
        }
        foreach ($deductions as $key => $value) {
            EmployeeDeduction::create([
                'employee_id' => $employee->id,
                'deduction_id' => $value,
            ]);
        }

        $employee->sickLeave()->update(['points' => $request->sick_leave]);

        createActivity('Update Employee', 'Employee '. $request->name.' was updated.', request()->getClientIp(true)); 

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
