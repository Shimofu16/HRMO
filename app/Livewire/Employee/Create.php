<?php

namespace App\Livewire\Employee;

use App\Models\Loan;
use App\Models\SalaryGrade;
use Livewire\Component;
use App\Models\Category;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Level;
use App\Models\SalaryGradeStep;

class Create extends Component
{
    public $employee;

    public $employee_number;
    public $ordinance_number;
    public $sick_leave_points;
    public $first_name;
    public $middle_name;
    public $last_name;

    public $category_id;
    public $department_id;
    public $level_id;
    public $salary_grade_id;
    public $salary_grade_step;
    public $designation_id;

    public $selected_allowances;
    public $loan_id;
    public $allowance_id;
    public $salary_grade_steps;
    public $selected_loans;

    public $loans;
    public $departments;
    public $categories;
    public $designations;
    public $salary_grades;
    public $allowances;
    public $levels;
    public $mandatory_deductions;
    public $non_mandatory_deductions;

    public $isJOSelected;

    public function updatedEmployeeId($value)
    {
        if ($value) {
            $this->validate([
                'employee_id' => ['required', 'unique:employees,employee_id'],
            ]);
        }
    }
    public function updatedOrdinanceItemNumber($value)
    {
        if ($value) {
            $this->validate([
                'ordinance_number' => ['required', 'unique:employees,ordinance_number'],
            ]);
        }
    }
    public function updatedSalaryGradeId($value)
    {
        if ($value) {
            $this->salary_grade_steps = SalaryGrade::find($value)->steps;
            // dd(   $this->salary_grade_steps);
        }
    }
    public function updatedCategoryId($value)
    {
        $this->isJOSelected = false;
        if ($value) {
            $category = Category::find($value);
            if ($category->category_code == "JO") {
                $this->isJOSelected = true;
            }
            // dd($category,$category->allowances, $this->isJOSelected);
            $this->allowances = $category->allowances;
        }
    }
    public function updatedLoanId($value)
    {
        if ($value && $this->selected_loans) {
            if (!array_key_exists($value, $this->selected_loans)) {
                $this->selected_loans[$value] = Loan::where('id', $value)->first();
            }
        } else {
            $this->selected_loans[$value] = Loan::where('id', $value)->first();
        }
        // dd( $this->selected_loans);
    }

    public function validateData()
    {
        $this->validate([
            'employee_number' => ['required', 'unique:employees,employee_number'],
            'ordinance_number' => ['required', 'unique:employees,ordinance_number'],
        ]);
    }

    public function mount()
    {
        $this->loans = Loan::all();
        $this->departments = Department::all();
        $this->categories = Category::all();
        $this->designations = Designation::all();
        $this->salary_grades = SalaryGrade::all();
        $this->levels = Level::all();
        $this->mandatory_deductions = Deduction::where('deduction_type', 'Mandatory')->get();
        $this->non_mandatory_deductions = Deduction::where('deduction_type', 'Non-Mandatory')->get();
        $this->isJOSelected = false;
    }

    public function render()
    {
        return view('livewire.employee.create');
    }
}
