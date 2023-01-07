<?php

use Illuminate\Support\Facades\Route;
use Modules\Akuntansi\Http\Controllers\JurnalAkuntansiController;
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
            Route::prefix('rekening')->group(function () {
                Route::post('create', 'store')->name('rekening.store');
                Route::get('rekening-list', 'srcRekening')->name('rekening.list');
            });
        });
        // link
        Route::controller(LinkAkuntansiController::class)->group(function () {
            Route::get('link', 'index')->name('link.index');
            Route::prefix('link')->group(function () {
                Route::get('list', 'list')->name('link.list');
                Route::post('create', 'store')->name('link.store');
                Route::get('list-index', 'listIndex')->name('listIndex.index');
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
