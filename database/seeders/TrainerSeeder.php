<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrainerSeeder extends Seeder
{
    public function run()
    {
        // Creating 6 trainers
        DB::table('trainers')->insert([
            [
                'first_name' => 'Jessica',
                'middle_name' => 'Marie',
                'last_name' => 'Smith',
                'specialization' => 'Strength Training',
                'description' => 'Expert in strength training and weightlifting.',
                'bio' => 'Jessica has over 10 years of experience in strength training and specializes in helping clients build muscle and strength.',
                'phone' => '123-456-7890',
                'email' => 'jessica.smith@example.com',
                'image' => 'trainers/team-1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'John',
                'middle_name' => 'Ann',
                'last_name' => 'Doe',
                'specialization' => 'Cardio',
                'description' => 'Cardio workout expert with a focus on endurance and fitness.',
                'bio' => 'John has been a personal trainer for 5 years, focusing on cardiovascular fitness, endurance, and fat loss.',
                'phone' => '234-567-8901',
                'email' => 'john.doe@example.com',
                'image' => 'trainers/team-2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Michael',
                'middle_name' => 'J',
                'last_name' => 'Jordan',
                'specialization' => 'Yoga',
                'description' => 'Yoga instructor with expertise in flexibility and relaxation.',
                'bio' => 'Michael has 7 years of experience teaching yoga, focusing on mindfulness, flexibility, and mental well-being.',
                'phone' => '345-678-9012',
                'email' => 'michael.jordan@example.com',
                'image' => 'trainers/team-3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'David',
                'middle_name' => 'R',
                'last_name' => 'Lee',
                'specialization' => 'CrossFit',
                'description' => 'CrossFit coach focused on high-intensity functional fitness training.',
                'bio' => 'David is passionate about CrossFit and has helped many athletes increase their strength, power, and endurance.',
                'phone' => '567-890-1234',
                'email' => 'david.lee@example.com',
                'image' => 'trainers/team-4.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Sarah',
                'middle_name' => 'Ellen',
                'last_name' => 'Williams',
                'specialization' => 'Pilates',
                'description' => 'Pilates trainer with a focus on core strength and flexibility.',
                'bio' => 'Sarah teaches Pilates to help clients build core strength, improve posture, and achieve a lean physique.',
                'phone' => '456-789-0123',
                'email' => 'sarah.williams@example.com',
                'image' => 'trainers/team-5.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Emily',
                'middle_name' => 'Marie',
                'last_name' => 'Brown',
                'specialization' => 'Rehabilitation',
                'description' => 'Specializes in injury rehabilitation and functional movement.',
                'bio' => 'Emily is a licensed physical therapist with expertise in injury rehabilitation and improving mobility and range of motion.',
                'phone' => '678-901-2345',
                'email' => 'emily.brown@example.com',
                'image' => 'trainers/team-6.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
