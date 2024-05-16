<?php

namespace App\Livewire\Employee;

use App\Models\AdminPassword;
use App\Models\Loan;
use App\Models\SalaryGrade;
use Livewire\Component;
use App\Models\Category;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Level;
use App\Models\SalaryGradeStep;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $employee;

    public $employee_number;
    public $employee_photo;
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
    public $allowances;
    public $holding_tax;
    public $levels;
    public $mandatory_deductions;
    public $non_mandatory_deductions;
    public $cos_monthly_salary;

    public $password;

    public bool  $isJOSelected = false;
    public bool  $isCOSSelected = false;
    public bool  $isWithHoldingTax = false;
    public bool $isAlreadyLogIn = false;

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
            // dd($category,$category->allowances, $this->isJOSelected);
            $this->allowances = Allowance::with('categories')->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
                ->get();
        }
    }
    public function updateLoans()
    {
        // Get selected loan IDs from the array keys
        $selectedLoanIds = array_keys($this->selected_loans);

        // Fetch loans based on selected IDs
        $this->loans = Loan::whereNotIn('id', $selectedLoanIds)->get();
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


    private function validateData()
    {
        $this->validate([
            'photo' => 'image|max:1024',
            'employee_number' => ['required', 'unique:employees,employee_number'],
            'ordinance_number' => ['required', 'unique:employees,ordinance_number'],
        ]);
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

    public function save()
    {

        $file_name = md5($this->employee_photo . microtime()).'.'.$this->employee_photo->extension();
        $this->employee_photo->storeAs('public/photos', $file_name);

        // Create a new employee instance
        $employee = Employee::create([
            'employee_number' => $this->employee_number,
            'employee_photo' => $file_name,
            'ordinance_number' => $this->ordinance_number,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
        ]);

        // Handle employee data

        if ($this->isJOSelected || $this->isCOSSelected) {
            $employee->data()->create([
                'department_id' => $this->department_id,
                'designation_id' => $this->designation_id,
                'category_id' => $this->category_id,
                'level_id' => $this->level_id,
                'cos_monthly_salary' => ($this->isCOSSelected) ? $this->cos_monthly_salary : null,
                'holding_tax' => ($this->isCOSSelected) ? (($this->holding_tax) ? $this->holding_tax : null) : null,
            ]);
        } else {
            $employee->data()->create([
                'department_id' => $this->department_id,
                'designation_id' => $this->designation_id,
                'category_id' => $this->category_id,
                'salary_grade_id' => $this->salary_grade_id,
                'salary_grade_step' => $this->salary_grade_step,
                'sick_leave_points' => $this->sick_leave_points,
                'holding_tax' => ($this->holding_tax) ? $this->holding_tax : null,
            ]);
        }
        if (!$this->isJOSelected || !$this->isCOSSelected) {
            if ($this->selectedAllowanceIds) {
                $selectedAllowanceIds = array_keys(array_filter($this->selectedAllowanceIds, 'boolval')); // Get selected IDs

                // Attach selected allowances using their IDs
                foreach ($selectedAllowanceIds as $selectedAllowanceId) {
                    $employee->allowances()->create(['allowance_id' => $selectedAllowanceId]);
                }
            }

            foreach ($this->getDeductions() as $value) {
                $employee->deductions()->create(['deduction_id' => $value]);
            }

            if ($this->arraySelectedLoans) {
                $loansData = [];

                foreach ($this->arraySelectedLoans as $loanId => $loanDetails) {
                    $loanAmount = $loanDetails['amount'];
                    $loanDuration = $loanDetails['duration'];
                    $selectedRanges = array_keys(array_filter($loanDetails['range'], 'boolval'));

                    $loansData[] = [
                        'loan_id' => $loanId,
                        'amount' => $loanAmount,
                        'duration' => $loanDuration,
                        'ranges' => $selectedRanges,
                    ];
                }
                // Create loans for the employee
                $employee->loans()->createMany($loansData);
            }
        }


        // Create activity
        createActivity('Create Employee', 'Employee ' . $employee->full_name . ' was created.', request()->getClientIp(true));

        // Redirect to the index page with a success message
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function login()
    {
        $current_password = AdminPassword::first()->password;
        if (Hash::check($this->password, $current_password)) {
            $this->isAlreadyLogIn = true;
        }
        return session()->flash('error', 'Wrong password.');
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
        $this->isWithHoldingTax = false;
        $this->isAlreadyLogIn = false;
    }

    public function render()
    {
        return view('livewire.employee.create');
    }
}
