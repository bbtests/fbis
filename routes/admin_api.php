<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum', 'can:admin']], function () {
    Route::resource('settings', SettingController::class)->except(['create', 'edit']);
});
