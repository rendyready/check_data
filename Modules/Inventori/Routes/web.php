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

Route::prefix('inventori')->group(function() {
    Route::get('/', 'InventoriController@index')-> name('inventori.index');
});
//Form beli Route
Route::group(['prefix' => 'inventori', 'controller' => BeliController::class,'middleware' => ['auth','web']], function()
{
    Route::get('beli','index')->name('beli.index');
    Route::get('beli/list','list')->name('beli.list');
    Route::post('beli/simpan','simpan')->name('beli.simpan');
});
//Master Supplier
Route::group(['prefix' => 'inventori', 'controller' => SupplierController::class,'middleware' => ['auth','web']], function()
{
    Route::get('supplier','index')->name('supplier.index'); Route::post('supplier/action','action')->name('supplier.action');
    Route::get('supplier/data','data')->name('supplier.data');
    Route::get('supplier/edit/{id}','edit')->name('supplier.edit');
});
//Form rusak Route
Route::group(['prefix' => 'inventori', 'controller' => RusakController::class,'middleware' => ['auth','web']], function()
{
    Route::get('rusak','index')->name('rusak.index');
    Route::post('rusak/simpan','simpan')->name('rusak.simpan');
});
//Form po Route
Route::group(['prefix' => 'inventori', 'controller' => PoController::class,'middleware' => ['auth','web']], function()
{
    Route::get('po','index')->name('po.index');
    Route::post('po/simpan','simpan')->name('po.simpan');
});
//Form po Route
Route::group(['prefix' => 'inventori', 'controller' => InvPenjualanController::class,'middleware' => ['auth','web']], function()
{
    Route::get('penjualan_inv','index')->name('penjualan_inv.index');
    Route::get('penjualan_inv/list','list')->name('penjualan_inv.list');
    Route::post('penjualan_inv/simpan','simpan')->name('penjualan_inv.simpan');
});