<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['id' => '1', 'dep_code' => 'GSO', 'dep_name' => 'General Services Office'],
            ['id' => '2', 'dep_code' => 'MENRO', 'dep_name' => 'Municipal Environment and Natural Resources Office'],
            ['id' => '3', 'dep_code' => 'Agriculture Office', 'dep_name' => 'Municipal Agriculture Office'],
            ['id' => '4', 'dep_code' => 'MHO', 'dep_name' => 'Municipal Health Office'],
            ['id' => '5', 'dep_code' => 'MSWD', 'dep_name' => 'Municipal Social Welfare and Development Office'],
            ['id' => '6', 'dep_code' => 'Engineering Office', 'dep_name' => 'Office of the Municipal Engineer'],
            ['id' => '7', 'dep_code' => 'Assessor Office', 'dep_name' => 'Office of the Municipal Assessor'],
            ['id' => '8', 'dep_code' => 'Accounting Office', 'dep_name' => 'Office of the Municipal Accountant'],
            ['id' => '9', 'dep_code' => 'MCR', 'dep_name' => 'Office of the Municipal Civil Registrar'],
            ['id' => '10', 'dep_code' => 'Treasurer Office', 'dep_name' => 'Office of the Municipal Treasurer'],
            ['id' => '11', 'dep_code' => 'MPDC', 'dep_name' => 'Municipal Planning and Development Coordinator'],
            ['id' => '12', 'dep_code' => 'Mayor Office', 'dep_name' => 'Office of the Municipal Mayor'],
            ['id' => '13', 'dep_code' => 'Budget Office', 'dep_name' => 'Municipal Budget Office'],
            ['id' => '14', 'dep_code' => 'SB Office', 'dep_name' => 'Sangguniang Bayan Office'],
            ['id' => '15', 'dep_code' => 'BPLO', 'dep_name' => 'Business Permit and Licensing Office'],
            ['id' => '16', 'dep_code' => 'CCC', 'dep_name' => 'Calauan Community College'],
            ['id' => '17', 'dep_code' => 'LCR', 'dep_name' => 'Local Civil Registral'],
            ['id' => '18', 'dep_code' => 'SEC', 'dep_name' => 'Sectoral'],
            ['id' => '19', 'dep_code' => 'MDRRMO', 'dep_name' => 'Municipal Disaster Risk Reduction and Management Office'],
            ['id' => '20', 'dep_code' => 'DILG', 'dep_name' => 'Department in Interior and Local Government'],
            ['id' => '21', 'dep_code' => 'VM Office', 'dep_name' => 'Office of the Municipal Vice Mayor'],
            ['id' => '22', 'dep_code' => 'HRMO', 'dep_name' => 'Human Resource Management Office'],
            ['id' => '23', 'dep_code' => 'ADMIN', 'dep_name' => 'Admin Office'],
            ['id' => '24', 'dep_code' => 'MTJ', 'dep_name' => 'Office of the Municipal Trial Judge'],
            // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
