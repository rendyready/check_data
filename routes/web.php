<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\MAreaController;
use App\Http\Controllers\Master\MJenisMenuController;
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
Route::middleware(['auth','web'])->group(function () {
    Route::view('/', 'dashboard');
    Route::match(['get', 'post'], '/dashboard', function(){
        return view('dashboard');
    });
});
//Master Area Route
Route::group(['prefix' => 'master', 'controller' => MAreaController::class,'middleware' => ['auth','web']], function()
{
    Route::get('area','index')->name('area.index'); Route::post('area/action','action')->name('action.area');
});
//Master Jenis Route
Route::group(['prefix' => 'master', 'controller' => MJenisMenuController::class,'middleware' => ['auth','web']], function()
{
    Route::get('jenis_menu','index')->name('jenis_menu.index'); Route::post('jenis_menu/sort','sort')->name('sort.jenis_menu');
    Route::post('jenis_menu/action','action')->name('action.jenis_menu');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
