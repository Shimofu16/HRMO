<?php

namespace Database\Seeders;

use App\Models\AdminPassword;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminPassword::create(['password'=> Hash::make('password')]);
    }
}
