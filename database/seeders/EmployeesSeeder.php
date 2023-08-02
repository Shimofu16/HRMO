<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Category;
use App\Models\Sgrade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $allowances = Allowance::all();
        $departments = Department::all();
        $designations = Designation::all();
        $categories = Category::all();
        $sgrades = Sgrade::all();

        DB::table('employees')->insert([
            [
                'emp_no' => 'A1B2C3D4',
                'oinumber' => 'A-01',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Max Smith',
                'department_id' => 1,
                'designation_id' => 1,
                'category_id' => $categories->random()->id,
                'allowance' => 'Hazard, Transportation, Laundry',
                'deduction' => 'PhilHealth, Pi-Loan',
            ],
            [
                'emp_no' => 'E5F6G7H8',
                'oinumber' => 'B-02',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Jane Smith',
                'department_id' => 2,
                'designation_id' => 2,
                'category_id' => $categories->random()->id,
                'allowance' => 'Subsistence, Representation, ACA&PERA',
                'deduction' => 'Lanbank, Conso/MPL, E-Loan',
            ],
            [
                'emp_no' => 'I9J0K1L2',
                'oinumber' => 'C-03',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Ava Johnson',
                'department_id' => 3,
                'designation_id' => 3,
                'category_id' => $categories->random()->id,
                'allowance' => 'Hazard, Laundry, Transportation',
                'deduction' => 'Lanbank, Pag-ibig',
            ],
            [
                'emp_no' => 'M3N4O5P6',
                'oinumber' => 'D-04',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Leo Davis',
                'department_id' => 4,
                'designation_id' => 4,
                'category_id' => $categories->random()->id,
                'allowance' => 'Transportation, ACA&PERA, Subsistence',
                'deduction' => 'Life & Ret., PhilHealth, E-Loan',
            ],
            [
                'emp_no' => 'Q7R8S9T0',
                'oinumber' => 'E-05',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Mia Thompson',
                'department_id' => 5,
                'designation_id' => 5,
                'category_id' => $categories->random()->id,
                'allowance' => 'Representation, Laundry, Hazard',
                'deduction' => 'Pag-ibig, Life & Ret.',
            ],
            [
                'emp_no' => 'U1V2W3X4',
                'oinumber' => 'F-06',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Ben Wilson',
                'department_id' => 6,
                'designation_id' => 6,
                'category_id' => $categories->random()->id,
                'allowance' => 'ACA&PERA, Subsistence, Transportation',
                'deduction' => 'Pi-Loan., WHT',
            ],
            [
                'emp_no' => 'Y5Z6A7B8',
                'oinumber' => 'G-07',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Zoe Anderson',
                'department_id' => 7,
                'designation_id' => 7,
                'category_id' => $categories->random()->id,
                'allowance' => 'Subsistence, Hazard, Laundry',
                'deduction' => 'Life & Ret.., Conso/MPL',
            ],
            [
                'emp_no' => 'C9D0E1F2',
                'oinumber' => 'H-08',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Eli Martinez',
                'department_id' => 8,
                'designation_id' => 8,
                'category_id' => $categories->random()->id,
                'allowance' => 'Representation, Transportation, ACA&PERA',
                'deduction' => 'Conso/MPL., Pag-ibig',
            ],
            [
                'emp_no' => 'G3H4I5J6',
                'oinumber' => 'I-09',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Ivy Taylor',
                'department_id' => 9,
                'designation_id' => 9,
                'category_id' => $categories->random()->id,
                'allowance' => 'Laundry, ACA&PERA, Hazard',
                'deduction' => 'Pag-ibig., PhilHealth',
            ],
            [
                'emp_no' => 'K7L8M9N0',
                'oinumber' => 'J-10',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Sam Clark',
                'department_id' => 10,
                'designation_id' => 10,
                'category_id' => $categories->random()->id,
                'allowance' => 'Transportation, Subsistence, Representation',
                'deduction' => 'PhilHealth., Life & Ret.',
            ],
            [
                'emp_no' => 'TYF678GI',
                'oinumber' => 'K-11',
                'sgrade_id' => $sgrades->random()->id,
                'name' => 'Ada Rodriguez',
                'department_id' => 11,
                'designation_id' => 11,
                'category_id' => $categories->random()->id,
                'allowance' => 'Hazard, ACA&PERA, Laundry',
                'deduction' => 'Life & Ret., E-Loan',
            ],

            // Add more records as needed

        ]);
    }
}
