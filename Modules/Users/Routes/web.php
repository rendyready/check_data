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
    Route::get('/edit/{id}','edit')->name('users.edit');
    Route::post('users/action','action')->name('users.action');
    Route::post('/reset/{id}','reset_pass')->name('password.reset');
});
//Akses Route
Route::group(['prefix' => 'users', 'controller' => AksesController::class,'middleware' => ['auth','web']], function()
{
    Route::get('akses','index')->name('akses.index'); Route::post('akses/action','action')->name('action.akses');
});