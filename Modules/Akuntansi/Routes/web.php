<?php
use Illuminate\Support\Facades\Route;
use Modules\Akuntansi\Http\Controllers\RekeningController;
use Modules\Akuntansi\Http\Controllers\LinkaktController;
use Modules\Akuntansi\Http\Controllers\ListaktController;


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
Route::get('/akuntansi/rekening',[RekeningController::class,'index'])->name('rek.index');
Route::post('/akuntansi/simpan',[RekeningController::class,'simpan'])->name('rek.simpan');

Route::get('/akuntansi/link_akt',[LinkaktController::class,'index'])->name('rek_link.index');

Route::get('/akuntansi/list_akt',[ListaktController::class,'index'])->name('rek_list.index');
Route::post('/akuntansi/list_akt/save',[ListaktController::class,'save'])->name('rek_list.save');
