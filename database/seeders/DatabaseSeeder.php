<?php

namespace Database\Seeders;

use App\Models\UserMembership;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(MembershipSeeder::class);
        $this->call(WorkoutGuideSeeder::class);
        $this->call(GallerySeeder::class);
        $this->call(TrainerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UserMembershipSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(TermsPolicySeeder::class);
        $this->call(WalkinMembershipSeeder::class);
    }
}
