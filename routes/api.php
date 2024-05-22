<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1;

Route::name('v1.')->prefix('/v1')->group(function (){
    Route::name('metrics.')->prefix('/metrics')->group(function (){
        Route::get('/run', v1\Metrics\RunMetric::class)
            ->name('run');

        Route::post('/save/{id}', v1\Metrics\Save::class)
            ->name('save');
    });
});
