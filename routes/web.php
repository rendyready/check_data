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

// Dashboard Route
Route::middleware(['auth', 'web'])->group(function () {
    Route::view('/', 'dashboard');
    Route::match(['get', 'post'], '/dashboard', function () {
        return view('dashboard');
    });
});
//Master Route
Route::group(['prefix' => 'master', 'middleware' => ['auth', 'web'], 'controller' => App\Http\Controllers\Master\MAreaController::class], function () {
    Route::get('area', 'index')->name('area.index');
});

// Plot
//test
Route::prefix('master')->group(function () {
    Route::get('plot', function () {
        return view('master.plot');
    });
});

// Route::

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
