<?php

namespace Database\Seeders;

use App\Models\Deduction;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeductionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deduction_names = ['GSIS', 'Pag-ibig', 'Phil Health', 'With Holding Tax'];
        $deduction_amount_types = ['percentage', 'fixed_amount'];
        $deduction_types = ['Mandatory', 'Non-Mandatory'];
        $deduction_ranges = ['1-15', '16-30'];
        $deductions = [
            [
                'deduction_code' => 'Life & Ret.',
                'deduction_name' =>  'Life & Retirement benefits',
                'deduction_amount' => 9,
                'deduction_amount_type' => 'percentage',
                'deduction_type' => $deduction_types[array_rand($deduction_types)],
                'deduction_range' => '1-15',
            ],
            [
                'deduction_code' => 'Pag-ibig',
                'deduction_name' =>  'Pag-ibig',
                'deduction_amount' => 100,
                'deduction_amount_type' => 'fixed_amount',
                'deduction_type' => $deduction_types[array_rand($deduction_types)],
                'deduction_range' => '16-31',
            ],
            [
                'deduction_code' => 'Phil Health',
                'deduction_name' =>  'Phil Health',
                'deduction_amount' => 2,
                'deduction_amount_type' => 'percentage',
                'deduction_type' => $deduction_types[array_rand($deduction_types)],
                'deduction_range' => '1-15',
            ],
            // [
            //     'deduction_code' => 'With Holding Tax',
            //     'deduction_name' =>  'With Holding Tax',
            //     'deduction_amount' => 100,
            //     'deduction_amount_type' => 'fixed_amount',
            //     'deduction_type' => $deduction_types[array_rand($deduction_types)],
            //     'deduction_range' => $deduction_ranges[array_rand($deduction_ranges)],
            // ],
        ];


        foreach ($deductions as $deduction) {
            Deduction::create($deduction);
        }
    }
}
