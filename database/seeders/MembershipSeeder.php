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
            'description' => 'Basic membership with limited access to gym facilities, including access to the gym floor and basic equipment. This membership is ideal for individuals who are just starting their fitness journey and require minimal resources.',
            'duration_value' => 1,
            'duration_unit' => 'months',
            'price' => 500.00,
            'is_active' => true,
        ]);

        \App\Models\Membership::create([
            'name' => 'Premium Membership',
            'description' => 'Premium membership with full access to all gym facilities, including advanced equipment, group classes, and personal training sessions. This membership is perfect for fitness enthusiasts who want a comprehensive workout experience.',
            'duration_value' => 1,
            'duration_unit' => 'months',
            'price' => 1000.00,
            'is_active' => true,
        ]);

        \App\Models\Membership::create([
            'name' => 'VIP Membership',
            'description' => 'VIP membership with exclusive benefits, including priority access to gym facilities, personalized training programs, nutrition consultations, and access to VIP-only areas. This membership is tailored for individuals seeking a premium and luxurious fitness experience.',
            'duration_value' => 1,
            'duration_unit' => 'months',
            'price' => 1500.00,
            'is_active' => true,
        ]);

        \App\Models\Membership::create([
            'name' => '1 day Access Membership',
            'description' => 'A one-day access membership for walk-in customers only. Ideal for occasional visitors or trial users.',
            'duration_value' => 1,
            'duration_unit' => 'days',
            'price' => 50.00,
            'is_active' => true,
            'walk_in_only' => true,
        ]);
    }
}
