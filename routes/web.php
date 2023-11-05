<?php

use App\Http\Controllers\CountDataController;
use App\Http\Controllers\CronjobController;
use App\Http\Controllers\ServerStatusController;
use App\Http\Controllers\VersionController;use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cron', [CronjobController::class, 'index']);
Route::get('/migrate', [CronjobController::class, 'migrate']);
Route::get('/encrypt/{pass}', [CronjobController::class, 'encrypt']);
Route::get('/getdata', [CronjobController::class, 'getdata']);
Route::get('/getdataupdate', [CronjobController::class, 'getdataupdate']);
Route::get('/sendcloud', [CronjobController::class, 'sendcloud']);

Route::get('/upgrade', [VersionController::class, 'upgrade']);
Route::get('/test', [VersionController::class, 'test']);
Route::get('/server', [ServerStatusController::class, 'server']);

// Route::get('/count_data', [CountDataServer::class, 'count_data']);
Route::get('/count_data', [CountDataController::class, 'countData']);
