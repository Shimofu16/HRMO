<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Aiden Php Artisan',
                'email' => 'aiden@admin.ph',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Rolyn Hazel',
                'email' => 'rolynhazel@free.ph',
                'password' => bcrypt('password'),
            ],
            // Add more records as needed
        ]);
    }
}
