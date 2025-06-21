<?php

namespace App\Http\Controllers;

use App\Models\ApiUsage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsageController extends Controller
{
    public function summary(Request $request) {
        $today = Carbon::today()->toDateString();
        $usage = ApiUsage::where('user_id', $request->user()->id)
            ->where('date', $today)
            ->first();
        
        return response()->json([
            'date' => $today,
            'used' => $usage->count ?? 0,
            'limit' => $request->user()->subscriptionTier->daily_limit,
            'remaining' => max(0, ($request->user()->subscriptionTier->daily_limit - ($usage->count ?? 0)))
        ]);
    }

    public function monthly(Request $request) {
        $user = $request->user();
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $total = ApiUsage::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('count');

        return response()->json([
            'month' => Carbon::now()->format('F Y'),
            'used' => $total
        ]);
    }
}
