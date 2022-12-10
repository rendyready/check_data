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
    Route::get('beli','index')->name('beli.index'); Route::post('beli/action','action')->name('action.beli');
    Route::get('beli/list','list')->name('beli.list');
    Route::post('beli/simpan','simpan')->name('beli.simpan');
});
//Master Supplier
Route::group(['prefix' => 'inventori', 'controller' => SupplierController::class,'middleware' => ['auth','web']], function()
{
    Route::get('supplier','index')->name('supplier.index'); Route::post('supplier/action','action')->name('action.supplier');
    Route::get('supplier/data','data')->name('supplier.data');
    Route::post('supplier/simpan','simpan')->name('supplier.simpan');
});