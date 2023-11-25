<?php

namespace App\Livewire\Employee;

use App\Models\Loan;
use App\Models\Sgrade;
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

    public function updatedSalaryGradeId($value)
    {
        if ($value) {
            $this->salary_grade_steps = SalaryGradeStep::where('salary_grade_id', $value)->get();
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
        }else{
            $this->selected_loans[$value] = Loan::where('id', $value)->first();
        }
        // dd( $this->selected_loans);
    }



    public function render()
    {
        return view('livewire.employee.create', [
            'loans' => Loan::all(),
            'departments' => Department::all(),
            'categories' => Category::all(),
            'designations' => Designation::all(),
            'sgrades' => Sgrade::all(),
            'allowances' => Allowance::pluck('allowance_code', 'id'),
            'mandatory_deductions' => Deduction::where('deduction_type', 'Mandatory')->get(),
            'non_mandatory_deductions' => Deduction::where('deduction_type', 'Non-Mandatory')->get(),
        ]);
    }
}
