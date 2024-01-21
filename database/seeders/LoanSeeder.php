<?php

namespace Database\Seeders;

use App\Models\Loan;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker =  Factory::create();
        $loans = [
            [
                'name' => 'Multi Purpose Loan (GSIS)',
                'description' => $faker->sentence(),
            ],
            [
                'name' => 'Multi Purpose Loan (Pag-ibig)',
                'description' => $faker->sentence(),
            ],
            [
                'name' => 'Emergency Loan (GSIS)',
                'description' => $faker->sentence(),
            ],
            [
                'name' => 'Education Loan (GSIS)',
                'description' => $faker->sentence(),
            ],
            [
                'name' => 'Policy Loan (GSIS)',
                'description' => $faker->sentence(),
            ],
            [
                'name' => 'GPAL (GSIS)',
                'description' => $faker->sentence(),
            ],
            [
                'name' => 'Computer Loan (GSIS)',
                'description' => $faker->sentence(),
            ],
        ];

        foreach ($loans as $key => $loan) {
            Loan::create($loan);
        }
    }
}
