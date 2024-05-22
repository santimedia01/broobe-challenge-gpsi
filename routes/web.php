<?php

use Illuminate\Support\Facades\Route;

Route::name('metrics.')->prefix('/metrics')->group(function () {
    Route::get('run', [App\Http\Controllers\MetricsViewController::class, 'run'])
        ->name('run');

    Route::get('/history', [App\Http\Controllers\MetricsViewController::class, 'history'])
        ->name('history');

    Route::get('/detail', [App\Http\Controllers\MetricsViewController::class, 'detail'])
        ->name('detail');
});

Route::get('/', function () {
    return to_route('metrics.run');
});


