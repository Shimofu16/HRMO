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
use App\Models\SalaryGradeStep;

class Create extends Component
{
    public $employee;
    public $salary_grade_id;
    public $loan_id;
    public $allowance_id;
    public $category_id;
    public $salary_grade_steps;
    public $selected_loans;
    public $selected_allowances;

    public $loans;
    public $departments;
    public $categories;
    public $designations;
    public $salary_grades;
    public $allowances;
    public $mandatory_deductions;
    public $non_mandatory_deductions;

    public function updatedSalaryGradeId($value)
    {
        if ($value) {
            $this->salary_grade_steps = SalaryGrade::find($this->salary_grade_id)->steps;
            // dd(   $this->salary_grade_steps);
        }
    }
    public function updatedCategoryId($value)
    {
        if ($value) {
            $this->selected_allowances = Allowance::where('category_id', $value)->get();
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

    public function mount()
    {
        $this->loans = Loan::all();
        $this->departments = Department::all();
        $this->categories = Category::all();
        $this->designations = Designation::all();
        $this->salary_grades = SalaryGrade::all();
        $this->allowances = Allowance::pluck('allowance_code', 'id');
        $this->mandatory_deductions = Deduction::where('deduction_type', 'Mandatory')->get();
        $this->non_mandatory_deductions = Deduction::where('deduction_type', 'Non-Mandatory')->get();
    }

    public function render()
    {
        return view('livewire.employee.create');
    }
}
