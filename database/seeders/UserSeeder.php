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
            'first_name' => 'Admin',
            'middle_name' => '',
            'last_name' => 'Admin',
            'address' => 'Blk 123 Lot 45 Phase 6',
            'phone_number' => '09123456678',
            'birth_date' => '2000-01-01',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff',
            'first_name' => 'Staff',
            'middle_name' => '',
            'last_name' => 'Member',
            'address' => '789 Work Avenue',
            'phone_number' => '09112233456',
            'birth_date' => '1990-06-10',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STAFF,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'John Doe',
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'photo' => 'user-photos/user-1.jpg',
            'address' => '123 Real Street',
            'phone_number' => '9876543210',
            'birth_date' => '2000-01-01',
            'email' => 'member@gmail.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MEMBER,
            'email_verified_at' => now(),
            'weight' => 70, // weight in kilograms
            'height' => 175, // height in centimeters
        ]);

        User::create([
            'name' => 'Jane Doe',
            'first_name' => 'Jane',
            'middle_name' => 'Marie',
            'last_name' => 'Doe',
            'photo' => 'user-photos/user-2.jpg',
            'address' => '456 Imaginary Lane',
            'phone_number' => '09112233445',
            'birth_date' => '1995-05-15',
            'email' => 'member2@gmail.com',
            'password' => Hash::make('securepassword'),
            'role' => User::ROLE_MEMBER,
            'email_verified_at' => now(),
            'weight' => 60, // weight in kilograms
            'height' => 165, // height in centimeters
        ]);
    }
}
