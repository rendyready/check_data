<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DetailNotaController;
use Modules\Dashboard\Http\Controllers\GaransiController;
use Modules\Dashboard\Http\Controllers\LaporanKasHarianKasirController;
use Modules\Dashboard\Http\Controllers\LostBillController;
use Modules\Dashboard\Http\Controllers\RefundController;
use Modules\Dashboard\Http\Controllers\RekapMenuController;
use Modules\Dashboard\Http\Controllers\RekapNotaController;
use Modules\Dashboard\Http\Controllers\RekapNotaHarianController;
use Modules\Dashboard\Http\Controllers\RekapNotaHarianKategoriController;

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
            Route::get('detail/select_user', 'select_user')->name('detail.select_user');
        });

        Route::controller(RekapNotaController::class)->group(function () {
            Route::get('rekap', 'index')->name('rekap.index');
            Route::get('rekap/show', 'show')->name('rekap.show');
            Route::get('rekap/select_waroeng', 'select_waroeng')->name('rekap.select_waroeng');
            Route::get('rekap/detail/{id}', 'detail')->name('rekap.detail');
            Route::get('rekap/select_user', 'select_user')->name('rekap.select_user');
        });

        Route::controller(RekapNotaHarianController::class)->group(function () {
            Route::get('harian', 'index')->name('harian.index');
            Route::get('harian/show', 'show')->name('harian.show');
            Route::get('harian/select_waroeng', 'select_waroeng')->name('harian.select_waroeng');
            Route::get('harian/select_user', 'select_user')->name('harian.select_user');
        });

        Route::controller(RekapMenuController::class)->group(function () {
            Route::get('rekap_menu', 'menu_summary')->name('rekap_menu.menu_summary');
            Route::get('rekap_menu/show', 'show')->name('rekap_menu.show');
            Route::get('rekap_menu/select_waroeng', 'select_waroeng')->name('rekap_menu.select_waroeng');
            Route::get('rekap_menu/select_tanggal', 'select_tanggal')->name('rekap_menu.select_tanggal');
            Route::get('rekap_menu/tanggal_rekap', 'tanggal_rekap')->name('rekap_menu.tanggal_rekap');
            Route::post('rekap_menu/delete_tgl', 'delete_tgl')->name('rekap_menu.delete_tgl');
            Route::post('rekap_menu/simpan_tgl', 'simpan_tgl')->name('rekap_menu.simpan_tgl');
            Route::get('rekap_menu/select_trans', 'select_trans')->name('rekap_menu.select_trans');
            Route::get('rekap_menu/select_sif', 'select_sif')->name('rekap_menu.select_sif');
            Route::get('rekap_menu_global', 'menu_global')->name('rekap_menu_global.menu_global');
            Route::get('rekap_menu_global/select_kategori', 'select_kategori')->name('rekap_menu_global.select_kategori');
            Route::get('rekap_menu_global/show_menu_global', 'show_menu_global')->name('rekap_menu_global.show_menu_global');
            Route::get('rekap_menu_global/export_by_menu', 'export_by_menu')->name('rekap_menu_global.export_by_menu');
            Route::get('rekap_menu_global/export_excel_akt', 'export_excel_akt')->name('rekap_menu_global.export_excel_akt');
            // Route::get('rekap_menu/menu_non_menu/{mw}/{date}', 'rekapNonMenu')->name('rekap_menu.menu_non_menu');
        });

        Route::controller(RefundController::class)->group(function () {
            Route::get('rekap_refund', 'index')->name('rekap_refund.index');
            Route::get('rekap_refund/show', 'show')->name('rekap_refund.show');
            Route::get('rekap_refund/select_waroeng', 'select_waroeng')->name('rekap_refund.select_waroeng');
            Route::get('rekap_refund/detail/{id}', 'detail')->name('rekap_refund.detail');
            Route::get('rekap_refund/select_user', 'select_user')->name('rekap_refund.select_user');
        });

        Route::controller(LostBillController::class)->group(function () {
            Route::get('rekap_lostbill', 'index')->name('rekap_lostbill.index');
            Route::get('rekap_lostbill/show', 'show')->name('rekap_lostbill.show');
            Route::get('rekap_lostbill/select_waroeng', 'select_waroeng')->name('rekap_lostbill.select_waroeng');
            Route::get('rekap_lostbill/detail/{id}', 'detail')->name('rekap_lostbill.detail');
            Route::get('rekap_lostbill/select_user', 'select_user')->name('rekap_lostbill.select_user');
        });

        Route::controller(GaransiController::class)->group(function () {
            Route::get('rekap_garansi', 'index')->name('rekap_garansi.index');
            Route::get('rekap_garansi/show', 'show')->name('rekap_garansi.show');
            Route::get('rekap_garansi/select_waroeng', 'select_waroeng')->name('rekap_garansi.select_waroeng');
            Route::get('rekap_garansi/select_user', 'select_user')->name('rekap_garansi.select_user');
        });

        Route::controller(LaporanKasHarianKasirController::class)->group(function () {
            Route::get('kas_kasir', 'index')->name('kas_kasir.index');
            Route::get('kas_kasir/show', 'show')->name('kas_kasir.show');
            Route::get('kas_kasir/select_waroeng', 'select_waroeng')->name('kas_kasir.select_waroeng');
            Route::get('kas_kasir/select_user', 'select_user')->name('kas_kasir.select_user');
            Route::get('kas_kasir/detail/{id}', 'detail')->name('kas_kasir.detail');
            Route::get('kas_kasir/detail_show/{id}', 'detail_show')->name('kas_kasir.detail_show');
            Route::get('kas_kasir/export_pdf/', 'export_pdf')->name('kas_kasir.export_pdf');
            Route::get('kas_kasir/select_sesi', 'select_sesi')->name('kas_kasir.select_sesi');
        });

        Route::controller(RekapNotaHarianKategoriController::class)->group(function () {
            Route::get('rekap_kategori', 'index')->name('rekap_kategori.index');
            Route::get('rekap_kategori/show', 'show')->name('rekap_kategori.show');
            Route::get('rekap_kategori/select_waroeng', 'select_waroeng')->name('rekap_kategori.select_waroeng');
            Route::get('rekap_kategori/select_user', 'select_user')->name('rekap_kategori.select_user');
            Route::get('rekap_kategori/tanggal_rekap', 'tanggal_rekap')->name('rekap_kategori.tanggal_rekap');
            Route::get('rekap_kategori/rekap_non_menu', 'rekap_non_menu')->name('rekap_kategori.rekap_non_menu');
        });
        Route::controller(RekapPenjualanKategoriMenuController::class)->group(function () {
            Route::get('rekap_penj_kat', 'index')->name('rekap_penj_kat.index');
            Route::get('rekap_penj_kat/show', 'show')->name('rekap_penj_kat.show');
            Route::get('rekap_penj_kat/select_waroeng', 'select_waroeng')->name('rekap_penj_kat.select_waroeng');
            Route::get('rekap_penj_kat/select_user', 'select_user')->name('rekap_penj_kat.select_user');
            Route::get('rekap_penj_kat/rekap_non_menu', 'rekap_non_menu')->name('rekap_penj_kat.rekap_non_menu');
        });
        Route::controller(RekapMenuHarianController::class)->group(function () {
            Route::get('menu_harian', 'index')->name('menu_harian.index');
            Route::get('menu_harian/show', 'show')->name('menu_harian.show');
            Route::get('menu_harian/select_waroeng', 'select_waroeng')->name('menu_harian.select_waroeng');
            Route::get('menu_harian/select_tanggal', 'select_tanggal')->name('menu_harian.select_tanggal');
            Route::get('menu_harian/tanggal_rekap', 'tanggal_rekap')->name('menu_harian.tanggal_rekap');
            Route::post('menu_harian/delete_tgl', 'delete_tgl')->name('menu_harian.delete_tgl');
            Route::post('menu_harian/simpan_tgl', 'simpan_tgl')->name('menu_harian.simpan_tgl');
            Route::get('menu_harian/select_trans', 'select_trans')->name('menu_harian.select_trans');
            Route::get('menu_harian/select_sif', 'select_sif')->name('menu_harian.select_sif');
            Route::get('menu_harian/export_excel', 'export_excel')->name('menu_harian.export_excel');
        });

        Route::controller(RekapAktivitasKasirController::class)->group(function () {
            Route::get('rekap_aktiv_laci', 'rekap_laci')->name('rekap_aktiv_laci.rekap_laci');
            Route::get('rekap_aktiv_laci/select_waroeng', 'select_waroeng')->name('rekap_aktiv_laci.select_waroeng');
            Route::get('rekap_aktiv_laci/select_user_laci', 'select_user_laci')->name('rekap_aktiv_laci.select_user_laci');
            Route::get('rekap_aktiv_laci/tampil_laci', 'tampil_laci')->name('rekap_aktiv_laci.tampil_laci');
            Route::get('rekap_aktiv_laci/detail_laci/{id}', 'detail_laci')->name('rekap_aktiv_laci.detail_laci');
            Route::get('rekap_aktiv_laci/detail_show_laci/{id}', 'detail_show_laci')->name('rekap_aktiv_laci.detail_show_laci');
            Route::get('rekap_aktiv_menu', 'rekap_hps_menu')->name('rekap_aktiv_menu.rekap_hps_menu');
            Route::get('rekap_aktiv_menu/select_user_menu', 'select_user_menu')->name('rekap_aktiv_menu.select_user_menu');
            Route::get('rekap_aktiv_menu/tampil_hps_menu', 'tampil_hps_menu')->name('rekap_aktiv_menu.tampil_hps_menu');
            Route::get('rekap_aktiv_menu/export_hapus_menu', 'export_hapus_menu')->name('rekap_aktiv_menu.export_hapus_menu');
            Route::get('rekap_aktiv_nota', 'rekap_hps_nota')->name('rekap_aktiv_nota.rekap_hps_nota');
            Route::get('rekap_aktiv_nota/rekap_hps_nota', 'rekap_hps_nota')->name('rekap_aktiv_nota.rekap_hps_nota');
            Route::get('rekap_aktiv_nota/select_user_nota', 'select_user_nota')->name('rekap_aktiv_nota.select_user_nota');
            Route::get('rekap_aktiv_nota/tampil_hps_nota', 'tampil_hps_nota')->name('rekap_aktiv_nota.tampil_hps_nota');
        });

        Route::controller(RekapNonMenuController::class)->group(function () {
            Route::get('non_menu', 'index')->name('non_menu.index');
            Route::get('non_menu/show', 'show')->name('non_menu.show');
            Route::get('non_menu/select_waroeng', 'select_waroeng')->name('non_menu.select_waroeng');
            Route::get('non_menu/select_user', 'select_user')->name('non_menu.select_user');
            Route::get('non_menu/export_excel', 'export_excel')->name('non_menu.export_excel');
            Route::get('non_menu/export_excel_month', 'export_excel_month')->name('non_menu.export_excel_month');
        });

        Route::controller(RekapSelisihController::class)->group(function () {
            Route::get('rekap_selisih', 'index')->name('rekap_selisih.index');
            Route::get('rekap_selisih/show', 'show')->name('rekap_selisih.show');
            Route::get('rekap_selisih_ujicoba', 'ujicoba')->name('rekap_selisih_ujicoba.ujicoba');
            Route::get('rekap_selisih/show_ujicoba', 'show_ujicoba')->name('rekap_selisih.show_ujicoba');
            Route::get('rekap_selisih/select_waroeng', 'select_waroeng')->name('rekap_selisih.select_waroeng');
            Route::get('rekap_selisih/select_user', 'select_user')->name('rekap_selisih.select_user');
            Route::get('rekap_selisih/export_excel', 'export_excel')->name('rekap_selisih.export_excel');
        });
    });
