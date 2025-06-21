<?php

namespace App\Http\Middleware;

use App\Models\ApiUsage;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiUsage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $today = Carbon::today()->toDateString();
        $usage = ApiUsage::firstOrCreate(
            ['user_id' => $user->id, 'date'=> $today],
            ['count' => 0]
        );

        $tier = $user->subscriptionTier->name;
        $limit = $user->subscriptionTier->daily_limit;

        if($tier === 'Premium') {
            $usage->increment('count');
            return $next($request);
        }

        if($usage->count >= $limit) {
            return response()->json([
                'message' => 'API rate limit exceeds for today'
            ], 429);
        }

        $usage->increment('count');

        return $next($request);
    }
}
