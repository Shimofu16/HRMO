<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            ['id' => '1', 'designation_code' => 'OFCR I', 'designation_name' => 'Officer I'],
            ['id' => '2', 'designation_code' => 'OFCR II', 'designation_name' => 'Officer II'],
            ['id' => '3', 'designation_code' => 'OFCR III', 'designation_name' => 'Officer III'],
            ['id' => '4', 'designation_code' => 'Clerk', 'designation_name' => 'Clerk'],
            ['id' => '5', 'designation_code' => 'Clerk I', 'designation_name' => 'Clerk I'],
            ['id' => '6', 'designation_code' => 'Clerk II', 'designation_name' => 'Clerk II'],
            ['id' => '7', 'designation_code' => 'Clerk III', 'designation_name' => 'Clerk III'],
            ['id' => '8', 'designation_code' => 'Assess Clerk I', 'designation_name' => 'Assessment Clerk I'],
            ['id' => '9', 'designation_code' => 'Assistant I', 'designation_name' => 'Assistant I'],
            ['id' => '10', 'designation_code' => 'Assistant II', 'designation_name' => 'Assistant II'],
            ['id' => '11', 'designation_code' => 'Assistant III', 'designation_name' => 'Assistant III'],
            ['id' => '12', 'designation_code' => 'Assistant IV', 'designation_name' => 'Assistant IV'],
            // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
