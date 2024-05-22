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
        $allowances = [
            [
                'allowance_code' => 'ACA&PERA',
                'allowance_name' => 'Additional Compensation Allowance and Personal Economic Relief Allowance',
                'allowance_ranges' => ['1-15', '16-31'],
                'allowance_amount' => '1000',
            ],
            [
                'allowance_code' => 'Hazard',
                'allowance_name' => 'Hazard Pay',
                'allowance_ranges' => ['1-15'],
                'allowance_amount' => '2500',
            ],
            [
                'allowance_code' => 'Subsistence',
                'allowance_name' => 'Subsistence Allowance',
                'allowance_ranges' => ['1-15'],
                'allowance_amount' => '1500',
            ],
            [
                'allowance_code' => 'Laundry',
                'allowance_name' => 'Laundry Allowance',
                'allowance_ranges' => ['1-15'],
                'allowance_amount' => '150',
            ],
            [
                'allowance_code' => 'Representation',
                'allowance_name' => 'Representation Allowance',
                'allowance_ranges' => ['1-15'],
                'allowance_amount' => '800',
            ],
            [
                'allowance_code' => 'Transportation',
                'allowance_name' => 'Transportation Allowance',
                'allowance_ranges' => ['1-15', '16-31'],
                'allowance_amount' => '1100',
            ],
            // Add more allowances here
        ];

        foreach ($allowances as $allowance) {
            $allowance =  Allowance::create([
                'allowance_code' => $allowance['allowance_code'],
                'allowance_name' =>  $allowance['allowance_name'],
                'allowance_ranges' => $allowance['allowance_ranges'],
                'allowance_amount' => $allowance['allowance_amount'],
            ]);
            if ($allowance['allowance_code'] == 'Representation' || $allowance['allowance_code'] == 'Transportation') {
                foreach ($rataTypes as $key => $type) {
                    $allowance->categories()->create([
                        'type' => $type['type'],
                        'amount' => $type['amount'],
                    ]);
                }
            }
            if ($allowance['allowance_code'] != 'Representation' && $allowance['allowance_code'] != 'Transportation') {
                $allowance->categories()->create(['department_id' => 4]);
            }
            if ($allowance['allowance_code'] == 'ACA&PERA') {
                $allowance->categories()->create(['category_id' => 1]);
                $allowance->categories()->create(['category_id' => 4]);
                $allowance->categories()->create(['category_id' => 5]);
                $allowance->categories()->create(['category_id' => 6]);
                $allowance->categories()->create(['department_id' => 4]);
            }
        }
    }
}
