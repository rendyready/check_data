<?php

use App\Http\Controllers\CountDataController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

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

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/coba/{table}', [App\Http\Controllers\Controller::class, 'getMasterId']);
// Route::get('/sendmaster/{target}', [App\Http\Controllers\MyController::class, 'sendMaster']);
// Route::get('/nyoba', [App\Http\Controllers\MyController::class, 'Nyoba']);
// Route::get('/upgradedbclient/{target}', [App\Http\Controllers\MyController::class, 'upgradeDb']);
// Route::get('/updateclient', [App\Http\Controllers\Controller::class, 'coba']);
// Route::get('/nonmenu', [App\Http\Controllers\Controller::class, 'non_menu']);
// Route::get('/update/pass', [App\Http\Controllers\Auth\LoginController::class, 'change_pass'])
//     ->middleware('web')
//     ->name('update.pass');
// Route::post('/users/pass/update', [App\Http\Controllers\Auth\LoginController::class, 'update_pass_save'])
//     ->middleware('web')
//     ->name('password.changes');
// Route::get('/users/noakses', [App\Http\Controllers\Auth\LoginController::class, 'no_akses'])->name('users.noakses');
// Route::get('/count-data', [App\Http\Controllers\ControlDataController::class, 'CountData']);

// // Dashboard Route
// Route::middleware(['auth', 'web'])->group(function () {
//     Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
// });

// Route::get('/', [HomeController::class, 'index']);

// Route::controller(HomeController::class)->group(function () {
//     Route::get('/', 'index')->name('home');
// });

Route::controller(CountDataController::class)->group(function () {
    Route::get('/', 'index')->name('count.index');
    Route::get('count/show_data', 'show_data')->name('count.show_data');
    Route::get('count/tampil', 'tampil')->name('count.tampil');
    Route::get('count/check_data', 'check_data')->name('count.check_data');
    Route::get('count/count_data', 'count_data')->name('count.count_data');
});

Route::get('/sse-endpoint', 'CountDataController@sseEndpoint');
