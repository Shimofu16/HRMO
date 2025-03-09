<?php

namespace App\Livewire\Employee;

use App\Models\AdminPassword;
use App\Models\Allowance;
use App\Models\Category;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAllowance;
use App\Models\Level;
use App\Models\Loan;
use App\Models\SalaryGrade;
use Carbon\Carbon;
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
    public $payroll_type;

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
        $this->isCOSSelected = false;
        if ($value) {
            $category = Category::find($value);
            if ($category->category_code == "JO") {
                $this->isJOSelected = true;
            }
            if ($category->category_code == "COS") {
                $this->isCOSSelected = true;
            }
            if ($this->department_id) {
                $department = Department::find($value);
                $category = Category::find($this->category_id);

                // dd($category,$category->allowances, $this->isJOSelected);
                $this->allowances = Allowance::with('categories')->whereHas('categories', function ($query) use ($category, $department) {
                    $query->where('category_id', $category->id)
                        ->orWhere('department_id', $department->id);
                })
                    ->get();
            }
        }
    }
    public function updatedDepartmentId($value)
    {
        if ($value && $this->category_id) {
            $department = Department::find($value);
            $category = Category::find($this->category_id);

            // dd($category,$category->allowances, $this->isJOSelected);
            $this->allowances = Allowance::with('categories')->whereHas('categories', function ($query) use ($category, $department) {
                $query->where('category_id', $category->id)
                    ->orWhere('department_id', $department->id);
            })
                ->get();
        }
    }
    public function updateLoans()
    {
        // Get selected loan IDs from the array keys
        $selectedLoanIds = array_keys($this->selected_loans);
        $loans_from_db_ids = [];
        foreach ($this->employee->loans as $key => $loan) {
            $loans_from_db_ids[] = $loan->loan_id;
        }
        $selectedLoanIds = array_merge($loans_from_db_ids, $selectedLoanIds);
        $this->loans = Loan::whereNotIn('id', $loans_from_db_ids)->get();
    }
    public function updatedLoanId($value)
    {
        if ($value && $this->selected_loans) {
            if (!array_key_exists($value, $this->selected_loans)) {
                $this->selected_loans[$value] = Loan::where('id', $value)->first();
                $this->updateLoans();
            }
        } else {
            $this->selected_loans[$value] = Loan::where('id', $value)->first();
        }
    }
    public function removeLoan($loan_id)
    {
        if (array_key_exists($loan_id, $this->selected_loans)) {
            unset($this->selected_loans[$loan_id]);
            $this->updateLoans();
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
        // dd($this->allowances);
        $file_name = $this->employee->employee_photo;
        if ($this->employee_photo) {
            $file_name = md5($this->employee_photo . microtime()) . '.' . $this->employee_photo->extension();
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
        if ($this->employee->data->category_id != $this->category_id) {
            $this->employee->promotions()->create([
                'old_category_id' => $this->employee->data->category_id,
                'new_category_id'=> $this->category_id
            ]);
        }
        if ($this->isJOSelected || $this->isCOSSelected) {
            $this->employee->data()->update([
                'department_id' => $this->department_id,
                'designation_id' => $this->designation_id,
                'category_id' => $this->category_id,
                'level_id' => $this->level_id,
                'cos_monthly_salary' => ($this->isCOSSelected) ? $this->cos_monthly_salary : null,
                'has_holding_tax' => $this->isWithHoldingTax,
                'payroll_type' => $this->payroll_type,
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
                'payroll_type' => $this->payroll_type,
            ]);
        }

        if (!$this->isJOSelected) {
            if ($this->allowances) {
                $this->employee->allowances()->delete();
                $category = Category::find($this->category_id);
                $department = Department::find($this->department_id);
                $salary_grade = SalaryGrade::find($this->salary_grade_id);
                // Attach selected allowances using their IDs
                foreach ($this->allowances as $allowance) {
                    $this->employee->allowances()->create(['allowance_id' => $allowance->id]);
                }
            }
            $this->employee->deductions()->delete();
            foreach ($this->getDeductions() as $value) {
                $this->employee->deductions()->create(['deduction_id' => $value]);
            }
            if ($this->arraySelectedLoans) {
                $loansData = [];

                foreach ($this->arraySelectedLoans as $loanId => $loanDetails) {
                    $amount_1_15 = $loanDetails['amount_1_15'];
                    $amount_16_31 = $loanDetails['amount_16_31'];
                    $startDate = $loanDetails['start_date'];
                    $endDate = $loanDetails['end_date'];
                    $duration = Carbon::parse($loanDetails['start_date'])->diffInMonths(Carbon::parse($loanDetails['end_date']));

                    // Create separate rows for 1-15 and 16-31
                    $loansData[] = [
                        'loan_id' => $loanId,
                        'amount' => $amount_1_15,
                        'period' => '1-15',
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'duration' => $duration,
                    ];

                    $loansData[] = [
                        'loan_id' => $loanId,
                        'amount' => $amount_16_31,
                        'period' => '16-31',
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'duration' => $duration,
                    ];
                }
                // Create loans for the employee
                $this->employee->loans()->createMany($loansData);
            }
        }


        // Create activity
        createActivity('Update Employee', 'Employee ' . $this->employee->full_name . ' was updated.', request()->getClientIp(true));

        // Redirect to the index page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee Updated successfully.');
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
        $loans_from_db_ids = [];
        foreach ($this->employee->loans as $key => $loan) {
            $loans_from_db_ids[] = $loan->loan_id;
        }

        $this->loans = Loan::whereNotIn('id', $loans_from_db_ids)->get();
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
        $this->isWithHoldingTax = $this->employee->data->has_holding_tax;
        $this->first_name = $this->employee->first_name;
        $this->middle_name = $this->employee->middle_name;
        $this->last_name = $this->employee->last_name;
        $this->category_id = $this->employee->data->category_id;
        $this->department_id = $this->employee->data->department_id;
        $this->payroll_type = $this->employee->data->payroll_type;
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
            if ($this->department_id && $this->category_id) {
                $department = Department::find($this->department_id);
                $category = Category::find($this->category_id);

                // dd($category,$category->allowances, $this->isJOSelected);
                $this->allowances = Allowance::with('categories')->whereHas('categories', function ($query) use ($category, $department) {
                    $query->where('category_id', $category->id)
                        ->orWhere('department_id', $department->id);
                })
                    ->get();
            }
            foreach ($this->employee->deductions as $key => $deduction) {
                if ($deduction->deduction->deduction_type == 'Non-Mandatory') {
                    $this->selectedNonMandatoryDeductionIds[$deduction->deduction->id] = $deduction->deduction->id;
                }
            }
        }


        $this->isAlreadyLogIn = false;
    }
    public function render()
    {
        return view('livewire.employee.edit');
    }
}
