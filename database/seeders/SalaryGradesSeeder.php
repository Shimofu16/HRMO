<?php

namespace Database\Seeders;

use App\Models\SalaryGradeStep;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SalaryGrade;

class SalaryGradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salary_grades = [
            [
                ['step' => 'Step 1', 'amount' => 10000],
                ['step' => 'Step 2', 'amount' => 12000],
                ['step' => 'Step 3', 'amount' => 14000],
                ['step' => 'Step 4', 'amount' => 16000],
                ['step' => 'Step 5', 'amount' => 18000],
                ['step' => 'Step 6', 'amount' => 20000],
                ['step' => 'Step 7', 'amount' => 22000],
                ['step' => 'Step 8', 'amount' => 24000],
                ['step' => 'Step 9', 'amount' => 26000],
                ['step' => 'Step 10', 'amount' => 28000],
            ],
            // 2
            [
                ['step' => 'Step 1', 'amount' => 12000],
                ['step' => 'Step 2', 'amount' => 14000],
                ['step' => 'Step 3', 'amount' => 16000],
                ['step' => 'Step 4', 'amount' => 18000],
                ['step' => 'Step 5', 'amount' => 20000],
                ['step' => 'Step 6', 'amount' => 22000],
                ['step' => 'Step 7', 'amount' => 24000],
                ['step' => 'Step 8', 'amount' => 26000],
                ['step' => 'Step 9', 'amount' => 28000],
                ['step' => 'Step 10', 'amount' => 30000],
            ],
            // 3
            [
                ['step' => 'Step 1', 'amount' => 14000],
                ['step' => 'Step 2', 'amount' => 16000],
                ['step' => 'Step 3', 'amount' => 18000],
                ['step' => 'Step 4', 'amount' => 20000],
                ['step' => 'Step 5', 'amount' => 22000],
                ['step' => 'Step 6', 'amount' => 24000],
                ['step' => 'Step 7', 'amount' => 26000],
                ['step' => 'Step 8', 'amount' => 28000],
                ['step' => 'Step 9', 'amount' => 30000],
                ['step' => 'Step 10', 'amount' => 32000],
                ['step' => 'Step 11', 'amount' => 34000],
            ],
            // 3
            [
                ['step' => 'Step 1', 'amount' => 16000],
                ['step' => 'Step 2', 'amount' => 18000],
            ],
        ];
        // dd($salary_grades);
        // Loop through the sa;art grades array and create records
        foreach ($salary_grades as $salary_grade) {
            SalaryGrade::create([
                'steps' => $salary_grade
            ]);
        }
    }
}
