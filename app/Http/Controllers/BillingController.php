<?php

namespace App\Http\Controllers;

use App\Models\BillingRecord;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request) {
        $user = $request->user();

        if ($user->subscriptionTier->name !== 'Premium') {
            return response()->json([
                'message' => 'Access denied. Billing summary is only available for premium users.'
            ], 403);
        }

        $records = BillingRecord::where('user_id', $user->id)->get();

        return response()->json([
            'records' => $records
        ]);
    }

    public function show(Request $request, $month) {
        $user = $request->user();
        
        if ($user->subscriptionTier->name !== 'Premium') {
            return response()->json([
                'message' => 'Access denied. Billing summary is only available for premium users.'
            ], 403);
        }

        $record = BillingRecord::where('user_id', $user->id)
            ->where('month', $month)
            ->first();

        if(!$record) {
            return response()->json(['message' => 'No billing record found for this month'], 404);
        }

        return response()->json($record);
    }
}
