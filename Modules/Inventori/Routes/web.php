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
    Route::get('stok/{id}', 'master_stok');
});
//Form Master Gudang
Route::group(['prefix' => 'inventori', 'controller' => GudangController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_gudang', 'index')->name('m_gudang.index');
    Route::get('m_gudang/list', 'list')->name('m_gudang.list');
    Route::post('m_gudang/action', 'action')->name('m_gudang.action');
    Route::get('m_gudang/edit/{id}', 'edit')->name('m_gudang.edit');
});
