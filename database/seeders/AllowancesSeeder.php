<?php

namespace Database\Seeders;

use App\Models\Allowance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllowancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allowances = [
            [
                'allowance_code' => 'ACA&PERA',
                'allowance_name' => 'Additional Compensation Allowance and Personal Economic Relief Allowance',
                'allowance_range' => '1-15',
                'allowance_amount' => '1000',
                'category_id' => '1'
            ],
            [
                'allowance_code' => 'Hazard',
                'allowance_name' => 'Hazard Pay',
                'allowance_range' => '1-15',
                'allowance_amount' => '2500',
                'category_id' => '1'
            ],
            [
                'allowance_code' => 'Subsistence',
                'allowance_name' => 'Subsistence Allowance',
                'allowance_range' => '1-15',
                'allowance_amount' => '1200',
                'category_id' => '1'
            ],
            [
                'allowance_code' => 'Laundry',
                'allowance_name' => 'Laundry Allowance',
                'allowance_range' => '1-15',
                'allowance_amount' => '500',
                'category_id' => '1'
            ],
            [
                'allowance_code' => 'Representation',
                'allowance_name' => 'Representation Allowance',
                'allowance_range' => '1-15',
                'allowance_amount' => '800',
                'category_id' => '1'
            ],
            [
                'allowance_code' => 'Transportation',
                'allowance_name' => 'Transportation Allowance',
                'allowance_range' => '1-15',
                'allowance_amount' => '1100',
                'category_id' => '1'
            ],
            // Add more allowances here
        ];

        foreach ($allowances as $allowance) {
            Allowance::create($allowance);
        }
    }
}
