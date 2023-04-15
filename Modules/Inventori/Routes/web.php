<?php

use illuminate\Support\Facades\Route;
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

Route::prefix('inventori')->group(function () {
    Route::get('/', 'InventoriController@index')->name('inventori.index');
});
//Form beli Route
Route::group(['prefix' => 'inventori', 'controller' => BeliController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('beli', 'index')->name('beli.index');
    Route::get('beli/select', 'select')->name('beli.select');
    Route::get('beli/list', 'list')->name('beli.list');
    Route::post('beli/simpan', 'simpan')->name('beli.simpan');
    Route::get('beli/history/{id}','hist_pemb')->name('beli.hist'); Route::get('beli/code','get_code')->name('beli.code');
    Route::get('beli/history_detail/{id}','hist_pemb_detail')->name('beli.hist_detail');
});
//Master Supplier
Route::group(['prefix' => 'inventori', 'controller' => SupplierController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('supplier', 'index')->name('supplier.index');
    Route::post('supplier/action', 'action')->name('supplier.action');
    Route::get('supplier/data', 'data')->name('supplier.data');
    Route::get('supplier/edit/{id}', 'edit')->name('supplier.edit');
});
//Form rusak Route
Route::group(['prefix' => 'inventori', 'controller' => RusakController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('rusak', 'index')->name('rusak.index');
    Route::post('rusak/simpan', 'simpan')->name('rusak.simpan');
});
//Form po Route
Route::group(['prefix' => 'inventori', 'controller' => PoController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('po', 'index')->name('po.index');
    Route::post('po/simpan', 'simpan')->name('po.simpan');
});
//Form penjualan Route
Route::group(['prefix' => 'inventori', 'controller' => InvPenjualanController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('penjualan_inv', 'index')->name('penjualan_inv.index');
    Route::get('penjualan_inv/list', 'list')->name('penjualan_inv.list');
    Route::post('penjualan_inv/simpan', 'simpan')->name('penjualan_inv.simpan');
});
//Form CHT Route
Route::group(['prefix' => 'inventori', 'controller' => ChtController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('cht', 'index')->name('cht.index');
    Route::get('cht/list', 'list')->name('cht.list');
    Route::post('cht/simpan', 'simpan')->name('cht.simpan');
});
//Form Input Stok Awal Route
Route::group(['prefix' => 'inventori', 'controller' => MStokController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('stok_awal', 'index')->name('stok_awal.index');
    Route::get('stok_awal/list/{id}', 'list')->name('stok_awal.list');
    Route::post('stok_awal/simpan', 'simpan')->name('stok_awal.simpan');
    Route::get('stok/{id}', 'master_stok')->name('stok.list');
    Route::get('stok_harga/{id_g}/{id_p}','get_harga')->name('get_stok.harga');
    Route::get('stok_so','so_index')->name('stok_so.index');
    Route::get('stok_so/list','so_list')->name('stok_so.list');
    Route::get('stok_so/create/{id}/{kat_id}','so_create')->name('stok_so.create');
    Route::post('stok_so/simpan','so_simpan')->name('stok_so.simpan');
});
//Form Master Gudang
Route::group(['prefix' => 'inventori', 'controller' => GudangController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_gudang', 'index')->name('m_gudang.index');
    Route::get('m_gudang/list', 'list')->name('m_gudang.list');
    Route::post('m_gudang/action', 'action')->name('m_gudang.action');
    Route::get('m_gudang/edit/{id}', 'edit')->name('m_gudang.edit');
    Route::get('gudang/out','gudang_out')->name('m_gudang_out.index');
    Route::post('gudang/out_simpan','gudang_out_save')->name('m_gudang_out.simpan');
    Route::get('gudang/terima','gudang_terima')->name('m_gudang.terima_tf');
    Route::get('gudang/listtf','gudang_list_tf')->name('gudang.tf_list'); Route::get('gudang/terima/history','gudang_terima_hist')->name('gudang_terima.hist');
    Route::post('gudang/terima/simpan','gudang_terima_simpan')->name('cht_keluar_gudang.simpan'); Route::get('gudang_tf/code','get_code');
    Route::get('gudang/out_hist/{id}','gudang_out_hist')->name('gudang.histori');

});
//Master BB
Route::group(['prefix' => 'inventori', 'controller' => MasterBBController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_bb', 'index')->name('m_bb.index');
    Route::post('m_bb/simpan', 'simpan')->name('simpan.m_bb');
    Route::get('m_bb/list/{id}', 'list')->name('m_bb.list');
});
//Pecah Gabung Barang
Route::group(['prefix' => 'inventori', 'controller' => PecahGabungController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('pecah_gabung', 'index')->name('pcb.index');
    Route::post('pecah_gabung/simpan', 'simpan')->name('simpan.pcb');
    Route::get('pecah_gabung/list','pcb_list')->name('pcb.list'); Route::get('pecah_gabung/code','get_code');
});
//Form Penjualan Internal
Route::group(['prefix' => 'inventori', 'controller' => PenjualanInternalController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('penj_gudang', 'index')->name('penj_gudang.index');
    Route::post('penj_gudang/simpan', 'simpan')->name('simpan.penj_gudang');
    Route::get('penj_gudang/list','penj_list')->name('penj_gudang.list');
    Route::get('hist_penj_g','hist_penj_g')->name('hist_penj_g.index');
});

//Laporan Kartu Stock
Route::group(['prefix' => 'inventori', 'controller' => KartuStockController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('kartu_stock', 'kartu_stk')->name('kartu_stock.kartu_stk');
    Route::get('kartu_stock/select_waroeng', 'select_waroeng')->name('kartu_stock.select_waroeng');
    Route::get('kartu_stock/select_gudang', 'select_gudang')->name('kartu_stock.select_gudang');
    Route::get('kartu_stock/select_bb', 'select_bb')->name('kartu_stock.select_bb');
    Route::get('kartu_stock/show', 'show')->name('kartu_stock.show');
    Route::get('rekap_stock', 'rekap_stk')->name('rekap_stock.rekap_stk');
    Route::get('rekap_stock/tampil_rekap', 'tampil_rekap')->name('rekap_stock.tampil_rekap');
});
//Laporan Pembelian
Route::group(['prefix' => 'inventori', 'controller' => LaporanPembelianController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('lap_pem_detail', 'lap_detail')->name('lap_pem_detail.lap_detail');
    Route::get('lap_pem_detail/select_waroeng', 'select_waroeng')->name('lap_pem_detail.select_waroeng');
    Route::get('lap_pem_detail/select_user', 'select_user')->name('lap_pem_detail.select_user');
    Route::get('lap_pem_detail/tampil_detail', 'tampil_detail')->name('lap_pem_detail.tampil_detail');
    Route::get('lap_pem_rekap', 'lap_rekap')->name('lap_pem_rekap.lap_rekap');
    Route::get('lap_pem_rekap/tampil_rekap', 'tampil_rekap')->name('lap_pem_rekap.tampil_rekap');
    Route::get('lap_pem_rekap/detail_rekap/{id}', 'detail_rekap')->name('lap_pem_rekap.detail_rekap');
    Route::get('lap_pem_rekap/harian_rekap', 'harian_rekap')->name('lap_pem_rekap.harian_rekap');
    Route::get('lap_pem_harian', 'lap_harian')->name('lap_pem_harian.lap_harian');
    Route::get('lap_pem_harian/select_waroeng_harian', 'select_waroeng_harian')->name('lap_pem_harian.select_waroeng_harian');
    Route::get('lap_pem_harian/harian_rekap', 'harian_rekap')->name('lap_pem_harian.harian_rekap');
});

//FORM RPH
Route::group(['prefix' => 'inventori', 'controller' => RphController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('rph', 'index')->name('rph.index');
    Route::get('rph/create', 'create')->name('rph.create');
    Route::get('rph/detail/{id}', 'detail')->name('rph.detail');
    Route::post('rph/simpan', 'simpan')->name('rph.simpan');
    Route::get('rph/edit/{id}','edit')->name('rph.edit');
    Route::put('rph/update','update')->name('rph.update');
    Route::get('rph_belanja','belanja')->name('belanja.index');
    Route::get('rph_belanja_detail/{id}','belanja_detail')->name('belanja.detail');
});














//Laporan Keluar Gudang
Route::group(['prefix' => 'inventori', 'controller' => LaporanKeluarGudangController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('lap_gudang_detail', 'lap_detail')->name('lap_gudang_detail.lap_detail');
    Route::get('lap_gudang_detail/select_waroeng', 'select_waroeng')->name('lap_gudang_detail.select_waroeng');
    Route::get('lap_gudang_detail/select_user', 'select_user')->name('lap_gudang_detail.select_user');
    Route::get('lap_gudang_detail/tampil_detail', 'tampil_detail')->name('lap_gudang_detail.tampil_detail');
    Route::get('lap_gudang_rekap', 'lap_rekap')->name('lap_gudang_rekap.lap_rekap');
    Route::get('lap_gudang_rekap/tampil_rekap', 'tampil_rekap')->name('lap_gudang_rekap.tampil_rekap');
    Route::get('lap_gudang_rekap/detail_rekap/{id}', 'detail_rekap')->name('lap_gudang_rekap.detail_rekap');
    Route::get('lap_gudang_harian', 'lap_harian')->name('lap_gudang_harian.lap_harian');
});

//Laporan Pengiriman
Route::group(['prefix' => 'inventori', 'controller' => LaporanPengirimanController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('lap_kirim_detail', 'lap_detail')->name('lap_kirim.lap_detail');
    Route::get('lap_kirim_rekap', 'lap_rekap')->name('lap_kirim.lap_rekap');
    Route::get('lap_kirim_harian', 'lap_harian')->name('lap_kirim.lap_harian');
});