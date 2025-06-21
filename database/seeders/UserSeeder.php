<?php

namespace Database\Seeders;

use App\Models\SubscriptionTier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $freeTier = SubscriptionTier::where('name', 'Free')->first();

        User::factory()->create([
            'name' => 'Free User',
            'email' => 'free@gmail.com',
            'password' => bcrypt('free'),
            'is_admin' => false,
            'subscription_tier_id' => $freeTier->id
        ]);

        $standardTier = SubscriptionTier::where('name', 'Standard')->first();

        User::factory()->create([
            'name' => 'Standard User',
            'email' => 'standard@gmail.com',
            'password' => bcrypt('standard'),
            'is_admin' => false,
            'subscription_tier_id' => $standardTier->id
        ]);

        $premiumTier = SubscriptionTier::where('name', 'Premium')->first();

        User::factory()->create([
            'name' => 'Premium User',
            'email' => 'premium@gmail.premium',
            'password' => bcrypt('password'),
            'is_admin' => false,
            'subscription_tier_id' => $premiumTier->id
        ]);
    }
}
