<?php
use Illuminate\Support\Facades\Route;
use Modules\Hrd\Http\Controllers\DivisiController;

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

Route::prefix('hrd')->middleware('auth', 'web')
    ->group(function () {
    Route::get('/', 'HrdController@index');

    Route::resource('master/divisi',DivisiController::class)->only(['index','show','store']);
    Route::get('master/divisi/get-parent',[DivisiController::class,'getParent']);
});
