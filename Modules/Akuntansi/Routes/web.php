<?php

use Illuminate\Support\Facades\Route;
use Modules\Akuntansi\Http\Controllers\JurnalAkuntansiController;
use Modules\Akuntansi\Http\Controllers\RekeningController;
use Modules\Akuntansi\Http\Controllers\LinkAkuntansiController;
use Modules\Akuntansi\Http\Controllers\LinkaktController;

// Route Global  Akuntansi 
// Welcome to jungle !!!

Route::get('/akuntansi/link_akt', [LinkaktController::class, 'index'])->name('rek_link.index');

// Master Akuntansi
Route::prefix('akuntansi')->middleware('auth', 'web')
    ->group(function () {
        // Rekening
        Route::controller(RekeningController::class)->group(function () {
            Route::get('rekening', 'index')->name('rekening.index');
            Route::prefix('rekening')->group(function () {
                Route::post('create', 'store')->name('rekening.store');
                Route::get('list', 'srcRekening')->name('rekening.list');
            });
        });
        // link
        Route::controller(LinkAkuntansiController::class)->group(function () {
            Route::get('link', 'index')->name('link.index');
            Route::prefix('link')->group(function () {
                Route::get('list', 'list')->name('link.list');
                Route::get('rekening', 'rekeninglink')->name('link.rekening');
                Route::post('create', 'store')->name('link.store');
            });
        });
        // Jurnla Akuntansi
        Route::controller(JurnalAkuntansiController::class)->group(function () {
            Route::get('jurnal', 'index')->name('jurnal.index');
            Route::prefix('jurnal')->group(function () {
                Route::get('list', 'list')->name('jurnal.list');
                Route::post('post', 'show')->name('jurnal.post');
            });
        });
    });
