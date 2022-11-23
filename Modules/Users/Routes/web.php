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
//Users Route
Route::group(['prefix' => 'users','controller' => UsersController::class,'middleware' => ['auth','web']], function()
{
    Route::get('/','index')->name('users.index');
    Route::get('/create','create')->name('users.create');
    Route::post('users/action','action')->name('users.akses');
});
//Akses Route
Route::group(['prefix' => 'users', 'controller' => AksesController::class,'middleware' => ['auth','web']], function()
{
    Route::get('akses','index')->name('akses.index'); Route::post('akses/action','action')->name('action.akses');
});