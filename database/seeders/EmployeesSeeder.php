<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Category;
use App\Models\SalaryGrade;
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
        $salary_grades = SalaryGrade::all();

       
    }
}
