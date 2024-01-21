<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use Illuminate\Database\Seeder;
// use Database\Seeders\EmployeesSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UsersSeeder::class,
            DepartmentsSeeder::class,
            DesignationsSeeder::class,
            CategoriesSeeder::class,
            SalaryGradesSeeder::class,
            AllowancesSeeder::class,
            DeductionsSeeder::class,
            LoanSeeder::class
        ]);
    }
}
