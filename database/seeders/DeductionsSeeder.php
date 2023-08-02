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
            ['deduction_code' => 'WHT', 'deduction_name' => 'Withholding Tax', 'deduction_amount' => '300'],
            ['deduction_code' => 'Life&Ret.', 'deduction_name' => 'Life and Retirement', 'deduction_amount' => '500'],
            ['deduction_code' => 'PhilHealth', 'deduction_name' => 'PhilHealth Contribution', 'deduction_amount' => '200'],
            ['deduction_code' => 'Pag-ibig', 'deduction_name' => 'Pag-ibig Contribution', 'deduction_amount' => '100'],
            ['deduction_code' => 'Lanbank', 'deduction_name' => 'Landbank', 'deduction_amount' => '700'],
            ['deduction_code' => 'PI-Loan', 'deduction_name' => 'Pag-ibig Loan', 'deduction_amount' => '600'],
            ['deduction_code' => 'Conso/MPL', 'deduction_name' => 'Consilidated/Multi-Purpose Loan', 'deduction_amount' => '400'],
            ['deduction_code' => 'Educ-Loan', 'deduction_name' => 'Education Loan', 'deduction_amount' => '120'],
            ['deduction_code' => 'POL-Loan', 'deduction_name' => 'Policy Loan', 'deduction_amount' => '130'],
            ['deduction_code' => 'GFAL', 'deduction_name' => 'GSIS Financial Assistance Loan', 'deduction_amount' => '380'],
            ['deduction_code' => 'Comp-Loan', 'deduction_name' => 'Computer Loan', 'deduction_amount' => '890'],
        // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($deductions as $deduction) {
            Deduction::create($deduction);
        }
    }
}
