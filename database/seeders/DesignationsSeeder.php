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
            ['designation_code' => 'OFCR I', 'designation_name' => 'Officer I'],
            ['designation_code' => 'OFCR II', 'designation_name' => 'Officer II'],
            ['designation_code' => 'OFCR III', 'designation_name' => 'Officer III'],
            ['designation_code' => 'Clerk', 'designation_name' => 'Clerk'],
            ['designation_code' => 'Clerk I', 'designation_name' => 'Clerk I'],
            ['designation_code' => 'Clerk II', 'designation_name' => 'Clerk II'],
            ['designation_code' => 'Clerk III', 'designation_name' => 'Clerk III'],
            ['designation_code' => 'Assess Clerk I', 'designation_name' => 'Assessment Clerk I'],
            ['designation_code' => 'Assistant I', 'designation_name' => 'Assistant I'],
            ['designation_code' => 'Assistant II', 'designation_name' => 'Assistant II'],
            ['designation_code' => 'Assistant III', 'designation_name' => 'Assistant III'],
            ['designation_code' => 'Assistant IV', 'designation_name' => 'Assistant IV'],
            // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
