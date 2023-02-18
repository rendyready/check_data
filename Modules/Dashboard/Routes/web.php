<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\RekapNotaController;
use Modules\Dashboard\Http\Controllers\DetailNotaController;
use Modules\Dashboard\Http\Controllers\RekapNotaHarianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Dashboard Route   

Route::prefix('dashboard')->middleware('auth', 'web')
    ->group(function () {

        Route::view('/', 'dashboard::dashboard');
        // Route::match(['get', 'post'], '/dashboard', function () {
        //     return view('dashboard::dashboard');
        // });

        Route::controller(DetailNotaController::class)->group(function () {
            Route::get('detail', 'index')->name('detail.index');
        });

        Route::controller(RekapNotaController::class)->group(function () {
            Route::get('rekap', 'index')->name('rekap.index');
            Route::get('rekap/show', 'show')->name('rekap.show');
            Route::get('rekap/select_waroeng', 'select_waroeng')->name('rekap.select_waroeng');
        });

        Route::controller(RekapNotaHarianController::class)->group(function () {
            Route::get('harian', 'index')->name('harian.index');
            Route::get('harian/show', 'show')->name('harian.show');
            Route::get('harian/select_waroeng', 'select_waroeng')->name('harian.select_waroeng');
        });

});