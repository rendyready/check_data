<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\RefundController;
use Modules\Dashboard\Http\Controllers\GaransiController;
use Modules\Dashboard\Http\Controllers\LostBillController;
use Modules\Dashboard\Http\Controllers\RekapMenuController;
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
            Route::get('detail/show', 'show')->name('detail.show');
            Route::get('detail/select_waroeng', 'select_waroeng')->name('detail.select_waroeng');
        });

        Route::controller(RekapNotaController::class)->group(function () {
            Route::get('rekap', 'index')->name('rekap.index');
            Route::get('rekap/show', 'show')->name('rekap.show');
            Route::get('rekap/select_waroeng', 'select_waroeng')->name('rekap.select_waroeng');
            Route::get('rekap/detail/{id}', 'detail')->name('rekap.detail');

        });

        Route::controller(RekapNotaHarianController::class)->group(function () {
            Route::get('harian', 'index')->name('harian.index');
            Route::get('harian/show', 'show')->name('harian.show');
            Route::get('harian/select_waroeng', 'select_waroeng')->name('harian.select_waroeng');
            Route::get('harian/select_operator', 'select_operator')->name('harian.select_operator');
        });

        Route::controller(RekapMenuController::class)->group(function () {
            Route::get('rekap_menu', 'index')->name('rekap_menu.index');
            Route::get('rekap_menu/show', 'show')->name('rekap_menu.show');
            Route::get('rekap_menu/select_waroeng', 'select_waroeng')->name('rekap_menu.select_waroeng');
        });

        Route::controller(RefundController::class)->group(function () {
            Route::get('rekap_refund', 'index')->name('rekap_refund.index');
            Route::get('rekap_refund/show', 'show')->name('rekap_refund.show');
            Route::get('rekap_refund/select_waroeng', 'select_waroeng')->name('rekap_refund.select_waroeng');
            Route::get('rekap_refund/detail/{id}', 'detail')->name('rekap_refund.detail');
        });

        Route::controller(LostBillController::class)->group(function () {
            Route::get('rekap_lostbill', 'index')->name('rekap_lostbill.index');
            Route::get('rekap_lostbill/show', 'show')->name('rekap_lostbill.show');
            Route::get('rekap_lostbill/select_waroeng', 'select_waroeng')->name('rekap_lostbill.select_waroeng');
            Route::get('rekap_lostbill/detail/{id}', 'detail')->name('rekap_lostbill.detail');
        });

        Route::controller(GaransiController::class)->group(function () {
            Route::get('rekap_garansi', 'index')->name('rekap_garansi.index');
            Route::get('rekap_garansi/show', 'show')->name('rekap_garansi.show');
            Route::get('rekap_garansi/select_waroeng', 'select_waroeng')->name('rekap_garansi.select_waroeng');
        });

});