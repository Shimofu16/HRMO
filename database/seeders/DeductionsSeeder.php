<?php

namespace Database\Seeders;

use App\Models\Deduction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeductionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deductions = [
            [
                'deduction_code' => 'SSS',
                'deduction_name' => 'Social Security System',
                'deduction_type' => 'Mandatory',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'PhilHealth',
                'deduction_name' => 'PhilHealth',
                'deduction_type' => 'Mandatory',
                'deduction_amount' => 500,
            ],
            [
                'deduction_code' => 'PagIbig',
                'deduction_name' => 'PagIbig',
                'deduction_type' => 'Mandatory',
                'deduction_amount' => 200,
            ],
            [
                'deduction_code' => 'Withholding Tax',
                'deduction_name' => 'Withholding Tax',
                'deduction_type' => 'Mandatory',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'SSS Loan',
                'deduction_name' => 'SSS Loan',
                'deduction_type' => 'Non Mandatory',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'PagIbig Loan',
                'deduction_name' => 'PagIbig Loan',
                'deduction_type' => 'Non Mandatory',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'Cash Advance',
                'deduction_name' => 'Cash Advance',
                'deduction_type' => 'Non Mandatory',
                'deduction_amount' => 1000,
            ],
        ];

        // Loop through the departments array and create records
        foreach ($deductions as $deduction) {
            Deduction::create($deduction);
        }
    }
}
