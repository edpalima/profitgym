<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Supplements'],
            ['name' => 'Drinks'],
            ['name' => 'Snacks'],
            ['name' => 'Meal Replacements'],
            ['name' => 'Healthy Foods'],
        ]);
    }
}
