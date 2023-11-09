<?php

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

use illuminate\Support\Facades\Route;
use Modules\Learn\Http\Controllers\MJabatanController;
use Modules\Learn\Http\Controllers\MPlotProduksiController;

Route::prefix('test')->group(function () {
    Route::get('/', 'LearnController@index');
});




// Plot Produksi

Route::prefix('master')->controller(MPlotProduksiController::class)
    ->middleware('web', 'auth')->group(function () {
        Route::get('plot-produksi', 'index')->name('plot-produksi.index');
        Route::post('plot-produksi/action', 'action')->name('plot-produksi.action');
    });

// Master Jabatan
Route::prefix('master')->controller(MJabatanController::class)
    ->middleware('web', 'auth')->group(function () {
        Route::get('level-jabatan', 'index')->name('level-jabatan.index');
        Route::post('level-jabatan', 'action')->name('level-jabatan.action');
    });
