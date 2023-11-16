<?php

namespace Database\Seeders;

use App\Models\SalaryGradeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sgrade;

class SalaryGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sgrades = [
            ['id'=> '1', 'sg_code' => 'SG-1', 'sg_name' => 'Salary Grade - 1'],
            ['id'=> '2', 'sg_code' => 'SG-2', 'sg_name' => 'Salary Grade - 2'],
            ['id'=> '3', 'sg_code' => 'SG-3', 'sg_name' => 'Salary Grade - 3'],
            ['id'=> '4', 'sg_code' => 'SG-4', 'sg_name' => 'Salary Grade - 4'],
            ['id'=> '5', 'sg_code' => 'SG-5', 'sg_name' => 'Salary Grade - 5'],
            ['id'=> '6', 'sg_code' => 'SG-6', 'sg_name' => 'Salary Grade - 6'],
            ['id'=> '7', 'sg_code' => 'SG-7', 'sg_name' => 'Salary Grade - 7'],
            ['id'=> '8', 'sg_code' => 'SG-8', 'sg_name' => 'Salary Grade - 8'],
            ['id'=> '9', 'sg_code' => 'SG-9', 'sg_name' => 'Salary Grade - 9'],
            ['id'=> '10', 'sg_code' => 'SG-10', 'sg_name' => 'Salary Grade - 10'],
            ['id'=> '11', 'sg_code' => 'SG-11', 'sg_name' => 'Salary Grade - 11'],
            ['id'=> '12', 'sg_code' => 'SG-12', 'sg_name' => 'Salary Grade - 12'],
            ['id'=> '13', 'sg_code' => 'SG-13', 'sg_name' => 'Salary Grade - 13'],
            ['id'=> '14', 'sg_code' => 'SG-14', 'sg_name' => 'Salary Grade - 14'],
        // Add more departments here
        ];

        $steps = [
            ['salary_grade_id' => 1, 'step'=>'Step 1 ', 'amount'=> 10000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 2 ', 'amount'=> 12000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 3 ', 'amount'=> 14000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 4 ', 'amount'=> 16000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 5 ', 'amount'=> 18000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 6 ', 'amount'=> 20000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 7 ', 'amount'=> 22000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 8 ', 'amount'=> 24000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 9 ', 'amount'=> 26000 ],
            ['salary_grade_id' => 1, 'step'=>'Step 10 ', 'amount'=> 28000 ],
            // 2
            ['salary_grade_id' => 2, 'step'=>'Step 1 ', 'amount'=> 12000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 2 ', 'amount'=> 14000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 3 ', 'amount'=> 16000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 4 ', 'amount'=> 18000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 5 ', 'amount'=> 20000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 6 ', 'amount'=> 22000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 7 ', 'amount'=> 24000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 8 ', 'amount'=> 26000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 9 ', 'amount'=> 28000 ],
            ['salary_grade_id' => 2, 'step'=>'Step 10 ', 'amount'=> 30000 ],
            // 3
            ['salary_grade_id' => 3, 'step'=>'Step 1 ', 'amount'=> 14000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 2 ', 'amount'=> 16000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 3 ', 'amount'=> 18000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 4 ', 'amount'=> 20000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 5 ', 'amount'=> 22000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 6 ', 'amount'=> 24000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 7 ', 'amount'=> 26000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 8 ', 'amount'=> 28000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 9 ', 'amount'=> 30000 ],
            ['salary_grade_id' => 3, 'step'=>'Step 10 ', 'amount'=> 32000 ],
        ];

        // Loop through the departments array and create records
        foreach ($sgrades as $sgrade) {
            Sgrade::create($sgrade);
        }

        foreach ($steps as $step) {
            SalaryGradeStep::create($step);
        }

    }
}
