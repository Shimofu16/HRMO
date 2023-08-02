<?php

namespace Database\Seeders;

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
            ['id'=> '1', 'sg_code' => 'SG-1', 'sg_name' => 'Salary Grade - 1', 'sg_amount' => '13780'],
            ['id'=> '2', 'sg_code' => 'SG-2', 'sg_name' => 'Salary Grade - 2', 'sg_amount' => '14578'],
            ['id'=> '3', 'sg_code' => 'SG-3', 'sg_name' => 'Salary Grade - 3', 'sg_amount' => '15486'],
            ['id'=> '4', 'sg_code' => 'SG-4', 'sg_name' => 'Salary Grade - 4', 'sg_amount' => '16443'],
            ['id'=> '5', 'sg_code' => 'SG-5', 'sg_name' => 'Salary Grade - 5', 'sg_amount' => '17453'],
            ['id'=> '6', 'sg_code' => 'SG-6', 'sg_name' => 'Salary Grade - 6', 'sg_amount' => '18520'],
            ['id'=> '7', 'sg_code' => 'SG-7', 'sg_name' => 'Salary Grade - 7', 'sg_amount' => '19644'],
            ['id'=> '8', 'sg_code' => 'SG-8', 'sg_name' => 'Salary Grade - 8', 'sg_amount' => '21029'],
            ['id'=> '9', 'sg_code' => 'SG-9', 'sg_name' => 'Salary Grade - 9', 'sg_amount' => '22396'],
            ['id'=> '10', 'sg_code' => 'SG-10', 'sg_name' => 'Salary Grade - 10', 'sg_amount' => '24567'],
            ['id'=> '11', 'sg_code' => 'SG-11', 'sg_name' => 'Salary Grade - 11', 'sg_amount' => '29075'],
            ['id'=> '12', 'sg_code' => 'SG-12', 'sg_name' => 'Salary Grade - 12', 'sg_amount' => '31230'],
            ['id'=> '13', 'sg_code' => 'SG-13', 'sg_name' => 'Salary Grade - 13', 'sg_amount' => '33591'],
            ['id'=> '14', 'sg_code' => 'SG-14', 'sg_name' => 'Salary Grade - 14', 'sg_amount' => '36341'],
        // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($sgrades as $sgrade) {
            Sgrade::create($sgrade);
        }
    }
}
