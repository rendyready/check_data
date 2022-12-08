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
//Master beli Route
Route::group(['prefix' => 'inventori', 'controller' => BeliController::class,'middleware' => ['auth','web']], function()
{
    Route::get('pembelian','index')->name('beli.index'); Route::post('beli/action','action')->name('action.beli');
});
