<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplementsId = Category::where('name', 'Supplements')->first()->id;
        // Seed 3 products with prices in PHP
        Product::create([
            'name' => 'Gold Standard Whey',
            'description' => 'Gold Standard Whey Protein by Optimum Nutrition, the world’s best-selling protein powder. It’s ideal for building lean muscle and helping you recover faster.',
            'price' => 3499.99,
            'stock_quantity' => 150,
            'is_active' => true,
            'image' => 'products/product-1.png',
            'category_id' => $supplementsId,
        ]);

        Product::create([
            'name' => 'Protein "Amino"',
            'description' => 'Amino Protein by Amino Energy is a premium blend of protein, amino acids, and energy-boosting ingredients to support performance and recovery.',
            'price' => 2199.99,
            'stock_quantity' => 80,
            'is_active' => true,
            'image' => 'products/product-2.png',
            'category_id' => $supplementsId,
        ]);

        Product::create([
            'name' => 'Protein Whey Ripped',
            'description' => 'Protein Whey Ripped is a fat-burning whey protein supplement, designed to help you burn fat while building lean muscle with added thermogenic ingredients.',
            'price' => 3999.99,
            'stock_quantity' => 60,
            'is_active' => true,
            'image' => 'products/product-3.png',
            'category_id' => $supplementsId,
        ]);
    }
}
