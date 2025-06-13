<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WalkinMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Membership::create([
            'id' => 1000,
            'name' => '1 day - Walk In',
            'description' => 'A one-day access membership for walk-in customers only. Ideal for occasional visitors or trial users.',
            'duration_value' => 1,
            'duration_unit' => 'days',
            'price' => 50.00,
            'is_active' => true,
            'walk_in_only' => true,
        ]);
    }
}
