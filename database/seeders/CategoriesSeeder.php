<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => '1', 'category_code' => 'PERM', 'category_name' => 'Permanent'],
            ['id' => '2', 'category_code' => 'JO', 'category_name' => 'Job Orders'],
            ['id' => '3', 'category_code' => 'COS', 'category_name' => 'Contract of Service'],
            ['id' => '4', 'category_code' => 'COTERM', 'category_name' => 'Coterminous'],
            ['id' => '5', 'category_code' => 'CAS', 'category_name' => 'Casual'],
            ['id' => '6', 'category_code' => 'ELECT', 'category_name' => 'Elective'],
            // Add more departments here
        ];

        // Loop through the departments array and create records
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
