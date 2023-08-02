<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $this->call(UsersSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(DesignationsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(SalaryGradesSeeder::class);
        $this->call(AllowancesSeeder::class);
        $this->call(DeductionsSeeder::class);
    }
}
