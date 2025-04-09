<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'first_name' => '123',
            'middle_name' => '',
            'last_name' => 'Admin',
            'address' => 'Blk 123 Lot 45 Phase 6',
            'phone_number' => '09123456678',
            'birth_date' => '2000-01-01',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'John Doe',
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'address' => '123 Real Street',
            'phone_number' => '9876543210',
            'birth_date' => '2000-01-01',
            'email' => 'member@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);
    }
}
