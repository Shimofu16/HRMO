<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Level;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Rata;
use App\Models\SalaryGrade;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $rataTypes = Rata::all();
        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $employee = Employee::create([
                'employee_number' => $i + 1,
                'ordinance_number' => str_pad($faker->numberBetween(00, 99), 2, '0', STR_PAD_LEFT) . '-' . Str::ucfirst($faker->randomLetter()),
                'first_name' => $faker->firstName($gender),
                'middle_name' => $faker->lastName($gender),
                'last_name' => $faker->lastName($gender),
            ]);
            $category = Category::find($faker->numberBetween(1, Category::count()));
            $department = Department::find($faker->numberBetween(1, Department::count()));
            $designation = Designation::find($faker->numberBetween(1, Designation::count()));
            $level = Level::find($faker->numberBetween(1, Level::count()));
            $has_holding_tax = false;
            $limit = 20833;
            $cos_monthly_salary = 0;
            if ($category->category_code == "JO" || $category->category_code == "COS") {
                $cos_monthly_salary = ($category->category_code == "COS") ? $faker->numberBetween(20000, 40000) : null;
                if ($cos_monthly_salary > $limit || $level->amount > $limit) {
                    $has_holding_tax = true;
                }
                $employee->data()->create([
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'category_id' => $category->id,
                    'level_id' => ($category->category_code == "COS") ?  null : $level->id,
                    'cos_monthly_salary' => $cos_monthly_salary,
                    'has_holding_tax' =>  $has_holding_tax,
                    'payroll_type' =>  $faker->randomElement(['ATM', 'Cash']),
                ]);
            }
            if ($category->category_code != "JO" && $category->category_code != "COS") {
                $sick_leave_points = $faker->randomFloat(null, 10, 15);
                $type = $faker->numberBetween(1, $rataTypes->count());
                $hasType = $faker->numberBetween(0, 1);
                $salary_grade = SalaryGrade::find($faker->numberBetween(1, SalaryGrade::count()));
                $salary_grade_step = 'Step ' . $faker->numberBetween(1, count($salary_grade->steps));

                foreach ($salary_grade->steps as $salary_grade_steps) {
                    if ($salary_grade_step == $salary_grade_steps['step'] && $salary_grade_steps['amount'] > $limit) {
                        $has_holding_tax = true;
                    }
                }
                $employee->data()->create([
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'category_id' => $category->id,
                    'salary_grade_id' => $salary_grade->id,
                    'rata_id' => ($hasType == 1) ? $rataTypes->find($type)->id : null,
                    'salary_grade_step' => $salary_grade_step,
                    'sick_leave_points' => $sick_leave_points,
                    'has_holding_tax' =>  $has_holding_tax,
                    'payroll_type' =>  $faker->randomElement(['ATM', 'Cash']),
                ]);

                // Query for allowances based on the selected IDs
                $allowances = Allowance::with('categories')->whereHas('categories', function ($query) use ($category, $department) {
                    $query->where('category_id', $category->id)
                        ->orWhere('department_id', $department->id);
                })
                    ->get();

                // Attach selected allowances using their IDs
                foreach ($allowances as $allowance) {
                    if ($allowance->allowance_code == "ACA&PERA") {
                        if (($category->id == 1 || $category->id == 4 || $category->id == 5 || $category->id == 6) || $department->dep_code == "MHO") {
                            $employee->allowances()->create(['allowance_id' => $allowance->id]);
                        }
                    }
                    if ($department->dep_code == "MHO" && $allowance->allowance_code == 'Hazard') {
                        $employee->allowances()->create([
                            'allowance_id' => $allowance->id,
                            'amount' => getHazard($salary_grade->id, $employee->data->salary_grade_step_amount)
                        ]);
                    }
                    if ($department->dep_code == "MHO" && $allowance->allowance_code == 'Subsistence') {
                        $employee->allowances()->create([
                            'allowance_id' => $allowance->id,
                        ]);
                    }
                    if ($department->dep_code == "MHO" && $allowance->allowance_code == 'Laundry') {
                        $employee->allowances()->create([
                            'allowance_id' => $allowance->id,
                        ]);
                    }
                    if ($hasType == 1) {
                        if ($allowance->allowance_code == 'Representation' || $allowance->allowance_code == 'Transportation') {
                            $employee->allowances()->create([
                                'allowance_id' => $allowance->id,
                                'amount' => $rataTypes->find($type)->amount
                            ]);
                        }
                    }
                }

                foreach ($this->getDeductions() as $deduction) {
                    $employee->deductions()->create(['deduction_id' => $deduction]);
                }

                $loanDetails = [
                    1 => [ // Loan ID as key
                        'amount' => 600,
                        'period' => 1-15,
                        'start_date' => Carbon::now()->subMonths(3)->format('Y-m-d'),
                        'end_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                    ],
                    2 => [ // Loan ID as key
                        'amount' => 500,
                        'period' => 1-15,
                        'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                        'end_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                    ],
                ];
                $loansData = [];

                foreach ($loanDetails as $loanId => $loanDetail) {
                    $start_date = Carbon::parse($loanDetail['start_date']);
                    $end_date = Carbon::parse($loanDetail['end_date']);
                    $duration = $start_date->diffInMonths($end_date);
                    $loansData[] = [
                        'loan_id' => $loanId,
                        'amount' => $loanDetail['amount'],
                        'period' => $loanDetail['period'],
                        'start_date' => $loanDetail['start_date'],
                        'end_date' => $loanDetail['end_date'],
                        'duration' => $duration,
                    ];
                }
                // Create loans for the employee
                $employee->loans()->createMany($loansData);
            }
        }
    }

    private function getDeductions()
    {
        $mandatory_deductions = Deduction::where('deduction_type', 'Mandatory')->get();
        $non_mandatory_deductions = Deduction::where('deduction_type', 'Non-Mandatory')->get();
        $array_mandatory_deductions = [];
        $array_non_mandatory_deductions = [];
        foreach ($mandatory_deductions as $mandatory_deduction) {
            $array_mandatory_deductions[] = $mandatory_deduction->id;
        }
        foreach ($non_mandatory_deductions as $mandatory_deduction) {
            if (random_int(0, 1) == 1) {
                $array_non_mandatory_deductions[] = $mandatory_deduction->id;
            }
        }

        return array_merge($array_mandatory_deductions, $array_non_mandatory_deductions);
    }
}
