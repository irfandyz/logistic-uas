<?php

require __DIR__ . '/authentication.php';

Route::middleware('auth')->group(function () {
    require __DIR__ . '/user/dashboard.php';
    require __DIR__ . '/user/master-data.php';
    require __DIR__ . '/user/logistic.php';
});

Route::get('/', function () {
    return redirect('/signin');
});
