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
                'employee_number' => $employee_number,
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
                    'type' => $rataTypes[$type]['type'],
                    'has_holding_tax' =>  $has_holding_tax,
                ]);

                // Generate a random number of allowances to select (between 1 and the total number)
                $numAllowances = $faker->numberBetween(3, Allowance::count());

                // Generate a random array of unique allowance IDs using Faker
                $allowanceIds = $faker->unique()->randomElements(Allowance::pluck('id'), 3);

                // Query for allowances based on the selected IDs
                $allowances = Allowance::with('categories')->whereIn('id', $allowanceIds)->get();



                // Attach selected allowances using their IDs
                foreach ($allowances as $allowance) {
                    if ($allowance->allowance_code == "ACA&PER") {
                        $temp = $allowance->whereHas('categories', function ($query) use ($category) {
                            $query->where('category_id', $category->id);
                        })->get();
                        if ($temp || $department->dep_code == "MHO") {
                            $employee->allowances()->create(['allowance_id' => $allowance->id]);
                        }
                    }
                    if ($department->dep_code == "MHO" && $allowance->allowance_code == 'Hazard') {
                        $employee->allowances()->create([
                            'allowance_id' => $allowance->id,
                            'amount' => $this->getHazard($salary_grade->id, $employee->data->salary_grade_step_amount)
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
                    if ($allowance->allowance_code == 'Representation' || $allowance->allowance_code == 'Transportation') {
                        $employee->allowances()->create([
                            'allowance_id' => $allowance->id,
                            'amount' => $rataTypes[$type]['amount']
                        ]);
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
    private function getHazard($salary_grade_id, $salary_grade)
    {
        switch ($salary_grade_id) {
            case 19:
                return $salary_grade * 0.25;
            case 20:
                return $salary_grade * 0.15;
            case 21:
                return $salary_grade * 0.13;
            case 22:
                return $salary_grade * 0.12;
            case 23:
                return $salary_grade * 0.11;
            case 24:
                return $salary_grade * 0.10;
            case 25:
                return $salary_grade * 0.10;
            case 26:
                return $salary_grade * 0.09;
            case 27:
                return $salary_grade * 0.08;
            case 28:
                return $salary_grade * 0.087;
            case 29:
                return $salary_grade * 0.06;
            case 30:
                return $salary_grade * 0.05;
        }
    }
}
