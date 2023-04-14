<?php

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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/coba/{table}', [App\Http\Controllers\Controller::class, 'getMasterId']);
Route::get('/update/pass',[App\Http\Controllers\Auth\LoginController::class, 'change_pass'])->name('update.pass');
// Dashboard Route
Route::middleware(['auth', 'web'])->group(function () {
    Route::view('/', 'home');
    Route::match(['get', 'post'], '/home', function () {
        return view('home');
    });
});