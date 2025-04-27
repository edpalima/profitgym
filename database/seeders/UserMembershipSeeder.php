<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '!=', 1)->get();
        $memberships = Membership::all();

        if ($users->isEmpty() || $memberships->isEmpty()) {
            $this->command->warn('No users or memberships found, skipping UserMembership seeding.');
            return;
        }

        foreach ($users as $user) {
            UserMembership::create([
                'user_id' => $user->id,
                'membership_id' => $memberships->random()->id,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'status' => 'APPROVED',
            ]);
        }
    }
}
