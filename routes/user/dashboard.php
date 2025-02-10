<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index');
});


