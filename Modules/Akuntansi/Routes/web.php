<?php
use Illuminate\Support\Facades\Route;
use Modules\Akuntansi\Http\Controllers\RekeningController;
use Modules\Akuntansi\Http\Controllers\LinkaktController;


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
Route::get('/akuntansi/rekening',[RekeningController::class,'index']);
Route::post('/akuntansi/simpan',[RekeningController::class,'simpan'])->name('rek.simpan');

Route::get('/akuntansi/link_akt',[LinkaktController::class,'index']);