<?php

namespace Database\Seeders;

use App\Models\SubscriptionTier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $premiumTier = SubscriptionTier::where('name', 'Premium')->first();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'subscription_tier_id' => $premiumTier->id
        ]);
    }
}
