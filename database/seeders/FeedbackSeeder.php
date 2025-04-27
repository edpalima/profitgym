<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', User::ROLE_MEMBER)->get();
        $memberships = Membership::all();

        $gymMessages = [
            "I have been coming to this gym for over a year now, and I can't express how much it has changed my life. The trainers are incredibly supportive, always pushing me to do my best. I love the variety of classes offered, and the equipment is always clean and up-to-date. Every time I step inside, the positive energy motivates me to push harder. Highly recommend to anyone serious about their fitness journey!",
            
            "Joining this gym has been one of the best decisions I’ve made for my health and wellbeing. The atmosphere here is electric — everyone from the staff to the members creates such a welcoming community. I’ve seen real results from the personalized training programs, and the nutrition guidance helped me completely transform my lifestyle. Five stars aren't enough for this place!",
            
            "After trying several gyms in the area, I finally found one that truly fits my needs. The facilities are outstanding, with everything from strength training to cardio machines available at any time. What sets this gym apart is the amazing coaching staff who are always ready to offer tips and encouragement. My strength and endurance have improved dramatically since I started here.",
            
            "If you’re looking for a gym that feels like a second home, this is the place. The staff genuinely cares about your progress, and the group classes are incredibly fun and motivating. I especially love the weekend bootcamps and the supportive environment that pushes you to go beyond your limits. Every session leaves me feeling stronger and more confident. This gym has truly exceeded all my expectations!"
        ];

        if ($users->isEmpty()) {
            $this->command->warn('No users found, skipping feedback seeding.');
            return;
        }

        foreach ($users as $user) { // Create feedback for each user
            Feedback::create([
            'user_id' => $user->id,
            'membership_id' => $memberships->isNotEmpty() ? $memberships->random()->id : null,
            'message' => $gymMessages[array_rand($gymMessages)],
            'rating' => rand(4, 5), // 1 to 5 stars
            'is_approved' => '1', // Approved by default
            ]);
        }
    }
}
