<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Membership::create([
            'name' => 'Basic Membership',
            'description' => 'Basic membership with limited access.',
            'duration_value' => 1,
            'duration_unit' => 'months',
            'price' => 500.00,
            'is_active' => true,
        ]);

        \App\Models\Membership::create([
            'name' => 'Premium Membership',
            'description' => 'Premium membership with full access.',
            'duration_value' => 1,
            'duration_unit' => 'months',
            'price' => 1000.00,
            'is_active' => true,
        ]);

        \App\Models\Membership::create([
            'name' => 'VIP Membership',
            'description' => 'VIP membership with exclusive benefits.',
            'duration_value' => 1,
            'duration_unit' => 'months',
            'price' => 1500.00,
            'is_active' => true,
        ]);
    }
}
