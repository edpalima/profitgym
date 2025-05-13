<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Supplements',
                'description' => 'Nutritional supplements to enhance your fitness journey.',
                'created_at' => now()
            ],
            [
                'name' => 'Drinks',
                'description' => 'Hydrating beverages to keep you refreshed.',
                'created_at' => now()
            ],
            [
                'name' => 'Snacks',
                'description' => 'Healthy snacks for your on-the-go lifestyle.',
                'created_at' => now()
            ],
            [
                'name' => 'Meal Replacements',
                'description' => 'Convenient meal replacements for busy days.',
                'created_at' => now()
            ],
            [
                'name' => 'Healthy Foods',
                'description' => 'Nutritious foods to support your health and fitness goals.',
                'created_at' => now()
            ],
        ]);
    }
}
