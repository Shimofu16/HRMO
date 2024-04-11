<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'name'=> 'JO',
                'amount' => 437
            ],
            [
                'name'=> 'Clean & Green',
                'amount' => 400
            ],
            [
                'name'=> 'Centrou',
                'amount' => 437
            ],
            [
                'name'=> 'MDRRMO',
                'amount' => 437
            ],
            [
                'name'=> 'Waste Management',
                'amount' => 300
            ],
        ];

        foreach ($levels as $key => $level) {
            Level::create($level);
        }
    }
}
