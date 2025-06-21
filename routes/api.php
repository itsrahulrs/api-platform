<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\UsageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('usage')->group(function () {
        Route::get('/', [UsageController::class, 'summary']);
        Route::get('/monthly', [UsageController::class, 'monthly']);
    });

    Route::prefix('billing')->group(function () {
        Route::get('/', [BillingController::class, 'index']);
        Route::get('/{month}', [BillingController::class, 'show']);
    });

    Route::middleware('check.api.usage')->get('/data', function () {
        return response()->json([
            'message' => 'Demo data'
        ]);
    });

    Route::middleware(['admin'])->prefix('/admin')->group(function () {
        Route::post('/set-tier', [AdminController::class, 'setUserTier']);
    });
});