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
use App\Models\SalaryGrade;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $rataTypes = [
            [
                'type' => 'OFFICER',
                'amount' => 6375,
            ],
            [
                'type' => 'HEAD',
                'amount' => 6375,
            ],
            [
                'type' => 'SB',
                'amount' => 6375,
            ],
            [
                'type' => 'MAYOR',
                'amount' => 7650,
            ],
            [
                'type' => 'VICE MAYOR',
                'amount' => 7650,
            ],
        ];
        for ($i = 0; $i < 20; $i++) {
            $employee_number = str_pad($i, 2, '0', STR_PAD_LEFT) . '-' . date('ymd') . '-' . mt_rand(0, 9999);

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
                ]);
            }
            if ($category->category_code != "JO" && $category->category_code != "COS") {
                $sick_leave_points = $faker->randomFloat(null, 10, 15);
                $type = $faker->numberBetween(0, count($rataTypes) - 1);
                $hasType = $faker->numberBetween(0, 1);
                $salary_grade = SalaryGrade::find($faker->numberBetween(1, SalaryGrade::count()));
                $salary_grade_step = 'Step ' . $faker->numberBetween(1, count($salary_grade->steps));
                foreach ($salary_grade->steps as $key => $salary_grade_steps) {
                    if ($salary_grade_step == $salary_grade_steps['step'] && $salary_grade_steps['amount'] > $limit) {
                        $has_holding_tax = true;
                    }
                }
                $employee->data()->create([
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'category_id' => $category->id,
                    'salary_grade_id' => $salary_grade->id,
                    'salary_grade_step' => $salary_grade_step,
                    'sick_leave_points' => $sick_leave_points,
                    'type' => ($hasType == 1) ? $rataTypes[$type]['type'] : null,
                    'has_holding_tax' =>  $has_holding_tax,
                ]);



                // Query for allowances based on the selected IDs
                $allowances = Allowance::with('categories')->get();



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
                                'amount' => $rataTypes[$type]['amount']
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
                        'duration' => 12,
                        'range' => ['1-15', '16-31'], // Sample loan range selection
                    ],
                    2 => [ // Loan ID as key
                        'amount' => 500,
                        'start_date' => 12,
                        'end_date' => 12,
                        'range' => ['1-15', '16-31'], // Sample loan range selection
                    ],
                ];
                $loansData = [];

                foreach ($loanDetails as $loanId => $loanDetails) {
                    $start_date = Carbon::now()->subMonths($faker->numberBetween(2,3));
                    $end_date = Carbon::now()->addMonths(3);
                    $duration = $start_date->diffInMonths(Carbon::parse($end_date));
                    $loansData[] = [
                        'loan_id' => $loanId,
                        'amount' => $loanDetails['amount'],
                        'start_date' => $start_date->format('Y-m-d'),
                        'end_date' => $end_date->format('Y-m-d'),
                        'duration' => $duration,
                        'ranges' => $loanDetails['range'],
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
        foreach ($mandatory_deductions as $key => $mandatory_deduction) {
            $array_mandatory_deductions[] = $mandatory_deduction->id;
        }
        foreach ($non_mandatory_deductions as $key => $mandatory_deduction) {
            if (random_int(0, 1) == 1) {
                $array_non_mandatory_deductions[] = $mandatory_deduction->id;
            }
        }


        return array_merge($array_mandatory_deductions, $array_non_mandatory_deductions);
    }

}