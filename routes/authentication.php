<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/signin', 'signin');
    Route::post('/signin', 'signin_post');
    Route::get('/signup', 'signup');
    Route::post('/signup', 'signup_post');
});


