<?php
use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\CountDataController;

// Dashboard Route

Route::prefix('dashboard')->middleware('web')
    ->group(function () {

        // Route::view('/', 'dashboard::dashboard');

        // Route::get('/count_data', [CountDataController::class, 'countData']);
        Route::controller(CountDataController::class)->group(function () {
            Route::get('count', 'index')->name('count.index');
            // Route::get('count/count_data', 'count_data')->name('count.count_data');
        });

    });