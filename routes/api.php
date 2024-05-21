<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin_api.php';

Route::get('/', function () {
    return response()->json([
        'host' => request()->getHost(),
        'env' => app()->environment(),
        'timestamp' => now()->timestamp,
    ]);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/vend', [VendingController::class, 'vend']);
});
