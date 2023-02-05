<?php

use Illuminate\Support\Facades\Route;

// Master Akuntansi
Route::prefix('akuntansi')->middleware('auth', 'web')
    ->group(function () {
        // Rekening
        Route::controller(RekeningController::class)->group(function () {
            Route::get('rekening', 'index')->name('rekening.index');
            Route::get('rekening/tampil', 'tampil')->name('rekening.tampil');
            Route::post('rekening/insert', 'simpan')->name('rekening.simpan');
            Route::get('rekening/copyrecord', 'copyrecord')->name('rekening.copyrecord');
            Route::get('rekening/validasinama', 'validasinama')->name('rekening.validasinama');
            Route::get('rekening/validasino', 'validasino')->name('rekening.validasino');
        });

        Route::controller(JurnalBankController::class)->group(function () {
            Route::get('jurnal_bank', 'index')->name('jurnal_bank.index');
            Route::get('jurnal_bank/tampil', 'tampil')->name('jurnal_bank.tampil');
            Route::get('jurnal_bank/carijurnalnoakun', 'carijurnalnoakun')->name('jurnal_bank.carijurnalnoakun');
            Route::get('jurnal_bank/carijurnalnamaakun', 'carijurnalnamaakun')->name('jurnal_bank.carijurnalnamaakun');
            Route::post('jurnal_bank/insert', 'simpan')->name('jurnal_bank.simpan');
            Route::post('jurnal_bank/validasi', 'validasi')->name('jurnal_bank.validasi');
            Route::get('jurnal_bank/rekeninglink', 'rekeninglink')->name('jurnal_bank.rekeninglink');
        });

        Route::controller(JurnalUmumController::class)->group(function () {
            Route::get('jurnal_umum', 'index')->name('jurnal_umum.index');
            Route::get('jurnal_umum/tampil', 'tampil')->name('jurnal_umum.tampil');
            Route::get('jurnal_umum/carijurnalnoakun', 'carijurnalnoakun')->name('jurnal_umum.carijurnalnoakun');
            Route::get('jurnal_umum/carijurnalnamaakun', 'carijurnalnamaakun')->name('jurnal_umum.carijurnalnamaakun');
            Route::post('jurnal_umum/insert', 'simpan')->name('jurnal_umum.simpan');
            Route::post('jurnal_umum/validasi', 'validasi')->name('jurnal_umum.validasi');
            Route::get('jurnal_umum/rekeninglink', 'rekeninglink')->name('jurnal_umum.rekeninglink');
        });

        Route::controller(JurnalKasController::class)->group(function () {
            Route::get('jurnal_kas', 'index')->name('jurnal_kas.index');
            Route::get('jurnal_kas/tampil', 'tampil')->name('jurnal.tampil');
            Route::get('jurnal_kas/carijurnalnoakun', 'carijurnalnoakun')->name('jurnal.carijurnalnoakun');
            Route::get('jurnal_kas/carijurnalnamaakun', 'carijurnalnamaakun')->name('jurnal.carijurnalnamaakun');
            Route::post('jurnal_kas/insert', 'simpan')->name('jurnal.simpan');
            Route::post('jurnal_kas/validasi', 'validasi')->name('jurnal.validasi');
            Route::get('jurnal_kas/rekeninglink', 'rekeninglink')->name('jurnal.rekeninglink');
        });

        Route::controller(LinkAkuntansiController::class)->group(function () {
            Route::get('link', 'index')->name('link.index');
            Route::get('link/rekening', 'rekeninglink')->name('link.rekening');
            Route::get('link/list', 'list')->name('link.list');
            Route::post('link/update', 'update')->name('link.update');
        });
    });
