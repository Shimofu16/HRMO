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
                'deduction_range' => '1-15',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'PHIC',
                'deduction_name' => 'PhilHealth',
                'deduction_type' => 'Mandatory',
                'deduction_range' => '1-15',
                'deduction_amount' => 500,
            ],
            [
                'deduction_code' => 'HDMF',
                'deduction_name' => 'PagIbig',
                'deduction_type' => 'Mandatory',
                'deduction_range' => '1-15',
                'deduction_amount' => 200,
            ],
            [
                'deduction_code' => 'WTAX',
                'deduction_name' => 'Withholding Tax',
                'deduction_type' => 'Mandatory',
                'deduction_range' => '1-15',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'PLN',
                'deduction_name' => 'PagIbig Loan',
                'deduction_type' => 'Non-Mandatory',
                'deduction_range' => '16-31',
                'deduction_amount' => 1000,
            ],
            [
                'deduction_code' => 'CA',
                'deduction_name' => 'Cash Advance',
                'deduction_type' => 'Non-Mandatory',
                'deduction_range' => '16-31',
                'deduction_amount' => 1000,
            ],
        ];

        foreach ($deductions as $deduction) {
            Deduction::create($deduction);
        }
    }
}
