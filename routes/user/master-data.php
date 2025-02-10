<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ShippingController;

Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::post('/category', 'store');
    Route::put('/category/{id}', 'update');
    Route::get('/category/{id}', 'destroy');
    Route::get('/category/find/{id}', 'find');
});

Route::controller(SupplierController::class)->group(function () {
    Route::get('/supplier', 'index');
    Route::post('/supplier', 'store');
    Route::put('/supplier/{id}', 'update');
    Route::get('/supplier/{id}', 'destroy');
    Route::get('/supplier/find/{id}', 'find');
});

Route::controller(ShippingController::class)->group(function () {
    Route::get('/shipping', 'index');
    Route::post('/shipping', 'store');
    Route::put('/shipping/{id}', 'update');
    Route::get('/shipping/{id}', 'destroy');
    Route::get('/shipping/find/{id}', 'find');
});

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer', 'index');
    Route::post('/customer', 'store');
    Route::put('/customer/{id}', 'update');
    Route::get('/customer/{id}', 'destroy');
    Route::get('/customer/find/{id}', 'find');
});

