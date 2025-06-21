<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\SubscriptionTier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        SubscriptionTier::create(['name' => 'Free', 'daily_limit' => 100]);
        SubscriptionTier::create(['name' => 'Standard', 'daily_limit' => 1000]);
        SubscriptionTier::create(['name' => 'Premium', 'daily_limit' => 10000]);
    }
}
