<?php

use Illuminate\Support\Facades\Route;
use Modules\Akuntansi\Http\Controllers\RekeningController;
use Modules\Akuntansi\Http\Controllers\LinkAkuntansiController;
use Modules\Akuntansi\Http\Controllers\LinkaktController;
use Modules\Akuntansi\Http\Controllers\ListaktController;

// Route Global  Akuntansi 
// Welcome to jungle !!!

Route::get('/akuntansi/link_akt', [LinkaktController::class, 'index'])->name('rek_link.index');

Route::get('/akuntansi/list_akt', [ListaktController::class, 'index'])->name('rek_list.index');
Route::post('/akuntansi/list_akt/save', [ListaktController::class, 'save'])->name('rek_list.save');


// Master Akuntansi
Route::prefix('akuntansi')->middleware('auth', 'web')
    ->group(function () {
        // Rekening
        Route::controller(RekeningController::class)->group(function () {
            Route::get('rekening', 'index')->name('rekening.index');
            Route::post('tambah', 'store')->name('rekening.store');
            Route::get('src-rekening', 'srcRekening')->name('resource_rekening');
        });
        // link
        Route::controller(LinkAkuntansiController::class)->group(function () {
            Route::get('link', 'index')->name('link');
        });
    });
