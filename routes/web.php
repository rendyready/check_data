<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\SatuanController;
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
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MAreaController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('area', 'index')->name('area.index');
    Route::post('area/action', 'action')->name('action.area');

    
});
//Master Route
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MAreaController::class,'middleware' => ['auth','web']], function()
{
    Route::get('area','index')->name('area.index');
    Route::post('area/action','action')->name('action.area');

});

//Master Route
Route::get('/satuan', [SatuanController::class,'index']);


//Master Route
Route::group(['prefix' => 'master', 'middleware' => ['auth', 'web'], 'controller' => App\Http\Controllers\Master\MAreaController::class], function () {
    Route::get('area', 'index')->name('area.index');
});





// Plot
Route::group(
    [
        'prefix' => 'master', 'middleware' => ['auth', 'web'],
        'controller' => \App\Http\Controllers\Master\MPlotProduksiController::class
    ],
    function () {
        Route::get('plot', 'index')->name('plot.index');
    }
);

// //test
Route::prefix('master')->group(function () {
    Route::get('index', function () {
        return view('CRMaster.index');
    });
    Route::prefix('plot')->group(function(){
        Route::post('create',[\App\Http\Controllers\Master\MPlotProduksiController::class,'store'])->name('plot.create');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
