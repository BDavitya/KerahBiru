<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

// Health check & test endpoints
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is running',
        'timestamp' => now()->toDateTimeString(),
        'environment' => config('app.env'),
    ]);
});

Route::get('/test-error', function () {
    abort(404, 'Test 404 Error - This should return JSON');
});

Route::get('/test-500', function () {
    throw new \Exception('Test 500 Error - This should return JSON with error details');
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-shake', [AuthController::class, 'verifyShake']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/complete-profile', [AuthController::class, 'completeProfile']);

// User Profile
Route::get('/profile', [UserController::class, 'getProfile']);
Route::post('/profile/update', [UserController::class, 'updateProfile']);
Route::post('/profile/preferences', [UserController::class, 'updatePreferences']);
Route::post('/update-password', [UserController::class, 'updatePassword']);

// Workers
Route::get('/workers', [WorkerController::class, 'index']);
Route::get('/workers/{id}', [WorkerController::class, 'show']);

// Orders
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'getUserOrders']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::post('/orders/{id}/confirm', [OrderController::class, 'confirmOrder']);
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
Route::post('/orders/{id}/photo-before', [OrderController::class, 'uploadPhotoBefore']);
Route::post('/orders/{id}/photo-after', [OrderController::class, 'uploadPhotoAfter']);
Route::post('/orders/{id}/review', [OrderController::class, 'submitReview']);

// Catch-all for undefined API routes (must be last)
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Endpoint tidak ditemukan. Periksa URL dan method HTTP yang digunakan.',
        'status_code' => 404
    ], 404);
});

Route::get('/debug-headers', function (Illuminate\Http\Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'Debug Headers',
        'headers' => [
            'Accept' => $request->header('Accept'),
            'Content-Type' => $request->header('Content-Type'),
            'All Headers' => $request->headers->all(),
        ],
        'request' => [
            'is_api' => $request->is('api/*'),
            'expectsJson' => $request->expectsJson(),
            'wantsJson' => $request->wantsJson(),
            'ajax' => $request->ajax(),
        ],
    ]);
});