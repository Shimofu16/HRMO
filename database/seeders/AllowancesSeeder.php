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
            ['id' => '1', 'allowance_code' => 'ACA&PERA', 'allowance_name' => 'Additional Compensation Allowance and Personal Economic Relief Allowance', 'allowance_amount' => '1000'],
            ['id' => '2', 'allowance_code' => 'Hazard', 'allowance_name' => 'Hazard Pay', 'allowance_amount' => '2500'],
            ['id' => '3', 'allowance_code' => 'Subsistence', 'allowance_name' => 'Subsistence Allowance', 'allowance_amount' => '1200'],
            ['id' => '4', 'allowance_code' => 'Laundry', 'allowance_name' => 'Laundry Allowance', 'allowance_amount' => '500'],
            ['id' => '5', 'allowance_code' => 'Representation', 'allowance_name' => 'Representation Allowance', 'allowance_amount' => '800'],
            ['id' => '6', 'allowance_code' => 'Transportation', 'allowance_name' => 'Transportation Allowance', 'allowance_amount' => '1100'],
        // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($allowances as $allowance) {
            Allowance::create($allowance);
        }
    }
}
