<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutcomeController;

Route::controller(ItemController::class)->group(function () {
    Route::get('/item', 'index');
    Route::get('/item/create', 'create');
    Route::post('/item', 'store');
    Route::get('/item/{id}/edit', 'edit');
    Route::put('/item/{id}', 'update');
    Route::get('/item/{id}', 'find');
    Route::get('/item/{id}', 'destroy');
});

Route::controller(IncomingController::class)->group(function () {
    Route::get('/incoming-item', 'index');
    Route::post('/incoming-item', 'store');
    Route::get('/incoming-item/find/{id}', 'find');
    Route::put('/incoming-item/{id}', 'update');
    Route::get('/incoming-item/{id}', 'destroy');

    Route::get('/incoming-item/detail/{id}', 'detail');
    Route::post('/incoming-item/detail/{id}', 'addItem');
    Route::put('/incoming-item/detail/{id}/update/{item_id}', 'updateItem');
    Route::get('/incoming-item/detail/{id}/delete', 'deleteItem');
    Route::get('/incoming-item/detail/{id}/find/{item_id}', 'findItem');
});

Route::controller(OutcomeController::class)->group(function () {
    Route::get('/outgoing-item', 'index');
    Route::post('/outgoing-item', 'store');
    Route::get('/outgoing-item/find/{id}', 'find');
    Route::put('/outgoing-item/{id}', 'update');
    Route::get('/outgoing-item/{id}', 'destroy');

    Route::get('/outgoing-item/detail/{id}', 'detail');
    Route::post('/outgoing-item/detail/{id}', 'addItem');
    Route::put('/outgoing-item/detail/{id}/update/{item_id}', 'updateItem');
    Route::get('/outgoing-item/detail/{id}/delete', 'deleteItem');
    Route::get('/outgoing-item/detail/{id}/find/{item_id}', 'findItem');
});
