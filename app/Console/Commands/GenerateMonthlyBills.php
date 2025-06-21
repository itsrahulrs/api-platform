<?php

namespace App\Console\Commands;

use App\Models\ApiUsage;
use App\Models\BillingRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMonthlyBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate monthly bills for premium users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $month = Carbon::now()->subMonth()->format('Y-m');

        $premiumUsers = User::whereHas('subscriptionTier', function($q) {
            $q->where('name', 'Premium');
        })->get();

        foreach($premiumUsers as $user) {
            $totalCalls = ApiUsage::where('user_id', $user->id)
                ->whereBetween('date', [
                    Carbon::now()->subMonth()->startOfMonth()->toDateString(),
                    Carbon::now()->subMonth()->endOfMonth()->toDateString()
                ])
                ->sum('count');
            
            $included = 10000;
            $extra = max(0, $totalCalls - $included);
            $amount = $extra * 0.01;

            BillingRecord::create([
                'user_id' => $user->id,
                'month' => $month,
                'included_calls' => $included,
                'extra_calls' => $extra,
                'amount' => $amount
            ]);

            $this->info("Generated bill for user {$user->id} - Month $month - Amount: $$amount");
        }

        return 0;
    }
}
