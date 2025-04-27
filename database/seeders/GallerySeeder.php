<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'image' => 'gallery/gallery-1.jpg',
                'title' => 'Powerlifting Highlights',
                'description' => 'A collection of our best powerlifting moments and competitions.',
            ],
            [
                'image' => 'gallery/gallery-2.jpg',
                'title' => 'Yoga Retreat 2024',
                'description' => 'Peaceful moments from our annual yoga and wellness retreat.',
            ],
            [
                'image' => 'gallery/gallery-3.jpg',
                'title' => 'HIIT Sessions',
                'description' => 'Snapshots from our high-intensity interval training classes.',
            ],
            [
                'image' => 'gallery/gallery-4.jpg',
                'title' => 'Strength Training Progress',
                'description' => 'Member transformations and progress in our strength program.',
            ],
            [
                'image' => 'gallery/gallery-5.jpg',
                'title' => 'Mobility & Stretching',
                'description' => 'Improving range of motion and flexibility – captured in action.',
            ],
            [
                'image' => 'gallery/gallery-6.jpg',
                'title' => 'Cardio Burnouts',
                'description' => 'Heart-pumping cardio workouts with great energy and sweat!',
            ],
            [
                'image' => 'gallery/gallery-7.jpg',
                'title' => 'Fitness Events',
                'description' => 'Behind-the-scenes from our fitness expo and community events.',
            ],
            [
                'image' => 'gallery/gallery-8.jpg',
                'title' => 'Personal Training Sessions',
                'description' => '1-on-1 coaching moments that bring real results.',
            ],
            [
                'image' => 'gallery/gallery-9.jpg',
                'title' => 'Group Fitness Fun',
                'description' => 'Energetic group classes that keep everyone motivated.',
            ],
            [
                'image' => 'gallery/gallery-10.jpg',
                'title' => 'Outdoor Bootcamps',
                'description' => 'Fitness sessions in the great outdoors for a refreshing change.',
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery + ['is_active' => true]);
        }
    }
}
