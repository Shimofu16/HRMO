<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\Category;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Level;
use App\Models\SalaryGrade;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['male', 'female']);
            $employee = Employee::create([
                'employee_number' => $faker->numberBetween(00000, 10000),
                'ordinance_number' => $faker->numberBetween(000000, 100000),
                'first_name' => $faker->firstName($gender),
                'middle_name' => $faker->lastName($gender),
                'last_name' => $faker->lastName($gender),
            ]);
            $category = Category::find($faker->numberBetween(1, Category::count()));
            $department = Department::find($faker->numberBetween(1, Department::count()));
            $designation = Designation::find($faker->numberBetween(1, Designation::count()));
            $level = Level::find($faker->numberBetween(1, Level::count()));
            $holding_tax = null;
            $limit = 20833;
            $cos_monthly_salary = 0;
            if ($category->category_code == "JO" || $category->category_code == "COS") {
                $cos_monthly_salary = ($category->category_code == "COS") ? $faker->numberBetween(20000,40000) : null;
                if ($cos_monthly_salary > $limit || $level->amount > $limit) {
                    $holding_tax = $faker->numberBetween(500,2000);
                }
                $employee->data()->create([
                    'department_id' => $department->id,
                    'designation_id' => $designation->id,
                    'category_id' => $category->id,
                    'level_id' =>  ($category->category_code == "COS") ?  null: $level->id,
                    'cos_monthly_salary' => $cos_monthly_salary
                ]);
            }
            if($category->category_code != "JO") {
                $sick_leave_points = $faker->randomFloat(null, 10, 15);
                if ($category->category_code != "COS") {
                    $salary_grade = SalaryGrade::find($faker->numberBetween(1, SalaryGrade::count()));
                    $salary_grade_step = 'Step ' . $faker->numberBetween(1, count($salary_grade->steps));
                    foreach ($salary_grade->steps as $key => $salary_grade_steps) {
                        if ($salary_grade_step == $salary_grade_steps['step'] && $salary_grade_steps['amount'] > $limit) {
                            $holding_tax = $faker->numberBetween(500,2000);
                        }
                    }
                    $employee->data()->create([
                        'department_id' => $department->id,
                        'designation_id' => $designation->id,
                        'category_id' => $category->id,
                        'salary_grade_id' => $salary_grade->id,
                        'salary_grade_step' => $salary_grade_step,
                        'sick_leave_points' => $sick_leave_points,
                        'holding_tax' => ($holding_tax) ?? $holding_tax,
                    ]);
                }

                // Generate a random number of allowances to select (between 1 and the total number)
                $numAllowances = $faker->numberBetween(1, Allowance::count());

                // Generate a random array of unique allowance IDs using Faker
                $allowanceIds = $faker->unique()->randomElements(Allowance::pluck('id'), $numAllowances);

                // Query for allowances based on the selected IDs
                $allowances = Allowance::whereIn('id', $allowanceIds)->get();



                // Attach selected allowances using their IDs
                foreach ($allowances as $allowance) {
                    $employee->allowances()->create(['allowance_id' => $allowance->id]);
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
                        'duration' => 12,
                        'range' => ['1-15', '16-31'], // Sample loan range selection
                    ],
                ];

                $loansData = [];

                foreach ($loanDetails as $loanId => $loanDetails) {
                    $loansData[] = [
                        'loan_id' => $loanId,
                        'amount' => $loanDetails['amount'],
                        'duration' => $loanDetails['duration'],
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
