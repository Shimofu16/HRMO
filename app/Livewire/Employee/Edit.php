<?php

namespace App\Livewire\Employee;

use App\Models\AdminPassword;
use App\Models\Allowance;
use App\Models\Category;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Level;
use App\Models\Loan;
use App\Models\SalaryGrade;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $employee;


    public $employee_photo;
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

    public array $selectedAllowanceIds;
    public array $selectedMandatoryDeductionIds;
    public array $selectedNonMandatoryDeductionIds;
    public array $arraySelectedLoans;
    public $loan_id;
    public $allowance_id;
    public $salary_grade_steps;
    public $selected_loans;

    public $loans;
    public $departments;
    public $categories;
    public $designations;
    public $salary_grades;
    public $levels;
    public $allowances;
    public $mandatory_deductions;
    public $non_mandatory_deductions;
    public $holding_tax;
    public $cos_monthly_salary;


    public $password;

    public bool  $isJOSelected = false;
    public bool  $isCOSSelected = false;
    public bool  $isWithHoldingTax = false;
    public bool $isAlreadyLogIn = false;


    public function updatedSalaryGradeId($value)
    {
        if ($value) {
            $this->salary_grade_steps = SalaryGrade::find($value)->steps;
            // dd(   $this->salary_grade_step);
        }
    }
    public function updatedCosMonthlySalary($value)
    {
        if ($value) {
            $limit = 20833;
            if ($value > $limit) {
                $this->isWithHoldingTax = true;
            }
            // dd($this->isWithHoldingTax  );
        }
    }
    public function updatedSalaryGradeStep($value)
    {
        if ($value) {
            $limit = 20833;
            foreach ($this->salary_grade_steps as $key => $salary_grade_step) {
                if ($value == $salary_grade_step['step'] && $salary_grade_step['amount'] > $limit) {
                    $this->isWithHoldingTax = true;
                }
            }
            // dd($this->isWithHoldingTax  );
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
            if ($category->category_code == "COS") {
                $this->isCOSSelected = true;
            }
            // dd($category,$category->allowances, $this->isJOSelected);
            $this->allowances = Allowance::with('categories')->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
                ->get();
        }
    }
    public function login()
    {
        $current_password = AdminPassword::first()->password;
        if (Hash::check($this->password, $current_password)) {
            $this->isAlreadyLogIn = true;
        }
        return session()->flash('error', 'Wrong password.');
    }

    public function save()
    {
        $file_name = $this->employee->employee_photo;
        if ($this->employee_photo) {
            $file_name = md5($this->employee_photo . microtime()).'.'.$this->employee_photo->extension();
            $this->employee_photo->storeAs('public/photos', $file_name);
        }

        // Create a new employee instance
        $this->employee->update([
            'employee_photo' => $file_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
        ]);

        // Handle employee data

        if ($this->isJOSelected || $this->isCOSSelected) {
            $this->employee->data()->update([
                'department_id' => $this->department_id,
                'designation_id' => $this->designation_id,
                'category_id' => $this->category_id,
                'level_id' => $this->level_id,
                'cos_monthly_salary' => ($this->isCOSSelected) ? $this->cos_monthly_salary : null,
                'has_holding_tax' => $this->isWithHoldingTax,
            ]);
        } else {
            $this->employee->data()->update([
                'department_id' => $this->department_id,
                'designation_id' => $this->designation_id,
                'category_id' => $this->category_id,
                'salary_grade_id' => $this->salary_grade_id,
                'salary_grade_step' => $this->salary_grade_step,
                // 'sick_leave_points' => $this->sick_leave_points,
                'has_holding_tax' => $this->isWithHoldingTax,
            ]);
        }

        if (!$this->isJOSelected) {
            if ($this->selectedAllowanceIds) {
                $this->employee->allowances()->delete();

                $selectedAllowanceIds = array_keys(array_filter($this->selectedAllowanceIds, 'boolval')); // Get selected IDs

                // Attach selected allowances using their IDs
                foreach ($selectedAllowanceIds as $selectedAllowanceId) {
                    $this->employee->allowances()->create(['allowance_id' => $selectedAllowanceId]);
                }
            }
            $this->employee->deductions()->delete();
            foreach ($this->getDeductions() as $value) {
                $this->employee->deductions()->create(['deduction_id' => $value]);
            }

            // if ($this->arraySelectedLoans) {
            //     $loansData = [];

            //     foreach ($this->arraySelectedLoans as $loanId => $loanDetails) {
            //         $loanAmount = $loanDetails['amount'];
            //         $loanDuration = $loanDetails['duration'];
            //         $selectedRanges = array_keys(array_filter($loanDetails['range'], 'boolval'));

            //         $loansData[] = [
            //             'loan_id' => $loanId,
            //             'amount' => $loanAmount,
            //             'duration' => $loanDuration,
            //             'ranges' => $selectedRanges,
            //         ];
            //     }
            //     // Create loans for the employee
            //     $this->employee->loans()->createMany($loansData);
            // }
        }


        // Create activity
        createActivity('Update Employee', 'Employee ' . $this->employee->full_name . ' was updated.', request()->getClientIp(true));

        // Redirect to the index page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }
    private function getDeductions()
    {
        $mandatory_deductions = [];

        foreach ($this->mandatory_deductions as $key => $mandatory_deduction) {
            $mandatory_deductions[] = $mandatory_deduction->id;
        }

        $non_mandatory_deductions = array_keys(array_filter($this->selectedNonMandatoryDeductionIds, 'boolval'));

        return array_merge($mandatory_deductions, $non_mandatory_deductions);
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
        // dd($this->employee);
        $this->isJOSelected = $this->employee->data->category->category_code == 'JO';
        $this->isCOSSelected = $this->employee->data->category->category_code == 'COS';
        $this->isWithHoldingTax = !empty($this->employee->data->holding_tax);
        $this->first_name = $this->employee->first_name;
        $this->middle_name = $this->employee->middle_name;
        $this->last_name = $this->employee->last_name;
        $this->category_id = $this->employee->data->category_id;
        $this->department_id = $this->employee->data->department_id;
        if ($this->isJOSelected) {
            $this->level_id = $this->employee->data->level_id;
        }
        if ($this->isCOSSelected) {
            $this->cos_monthly_salary = $this->employee->data->cos_monthly_salary;
        }
        if (!$this->isCOSSelected &&  !$this->isJOSelected) {
            $this->salary_grade_id = $this->employee->data->salary_grade_id;
            $this->salary_grade_steps = SalaryGrade::find($this->employee->data->salary_grade_id)->steps;
            $this->salary_grade_step = $this->employee->data->salary_grade_step;
              // dd($this->selectedAllowanceIds);
        $limit = 20833;
        foreach ($this->salary_grade_steps as $key => $salary_grade_step) {
            if ($this->employee->data->salary_grade_step == $salary_grade_step['step'] && $salary_grade_step['amount'] > $limit) {
                $this->isWithHoldingTax = true;
            }
        }


        }
        $this->designation_id = $this->employee->data->designation_id;
        if (!$this->isJOSelected) {
            $this->allowances = Allowance::with('categories')->whereHas('categories', function ($query) {
                $query->where('category_id', $this->employee->data->category_id);
            })
                ->get();

            foreach ($this->employee->allowances as $key => $allowance) {
                $this->selectedAllowanceIds[$allowance->allowance->id] = $allowance->allowance->id;
            }
            foreach ($this->employee->deductions as $key => $deduction) {
                if ($deduction->deduction->deduction_type == 'Non-Mandatory') {
                    $this->selectedNonMandatoryDeductionIds[$deduction->deduction->id] = $deduction->deduction->id;
                }
            }
        }


        $this->holding_tax = $this->employee->data->holding_tax;

        $this->isAlreadyLogIn = false;
    }
    public function render()
    {
        return view('livewire.employee.edit');
    }
}
