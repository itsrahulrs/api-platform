<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionTier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function setUserTier(Request $request) {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'tier_id' => 'required|exists:subscription_tiers,id',
            ]);
            
            $user = User::find($request->user_id);
            $tier = SubscriptionTier::find($request->tier_id);

            $user->subscription_tier_id = $tier->id;
            $user->save();

            return response()->json([
                'message' => "Tier updated to {$tier->name}"
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
