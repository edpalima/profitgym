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

        // Add 3 more products
        Product::create([
            'name' => 'Anabol',
            'description' => 'Anabol is a high-calorie protein powder designed for individuals looking to gain weight and build muscle mass effectively.',
            'price' => 2999.99,
            'stock_quantity' => 100,
            'is_active' => true,
            'image' => 'products/product-4.png',
            'category_id' => $supplementsId,
        ]);

        Product::create([
            'name' => 'Active Whey Protein',
            'description' => 'Active Whey Protein is a premium protein supplement designed to support muscle recovery and growth, with a delicious taste and easy mixability.',
            'price' => 1599.99,
            'stock_quantity' => 200,
            'is_active' => true,
            'image' => 'products/product-5.png',
            'category_id' => $supplementsId,
        ]);

        Product::create([
            'name' => 'PROTHN WHEY RIPPED',
            'description' => 'PROTHN WHEY RIPPED is a unique protein blend that combines whey protein with fat-burning ingredients to support weight loss and muscle definition.',
            'price' => 999.99,
            'stock_quantity' => 250,
            'is_active' => true,
            'image' => 'products/product-6.png',
            'category_id' => $supplementsId,
        ]);
    }
}
