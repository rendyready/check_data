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
Route::middleware(['auth','web'])->group(function () {
    Route::view('/', 'dashboard');
    Route::match(['get', 'post'], '/dashboard', function(){
        return view('dashboard');
    });
});
//Master Area Route
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MAreaController::class,'middleware' => ['auth','web']], function()
{
    Route::get('area','index')->name('area.index'); Route::post('area/action','action')->name('action.area');
});
//Master Jenis Route
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MJenisMenuController::class,'middleware' => ['auth','web']], function()
{
    Route::get('jenis_menu','index')->name('jenis_menu.index'); Route::post('jenis_menu/sort','sort')->name('sort.jenis_menu');
    Route::post('jenis_menu/action','action')->name('action.jenis_menu');
});
//Master SubJenis
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\SubJenisMController::class,'middleware' => ['auth','web']], function()
{
    Route::get('sub_jenis_menu','index')->name('sub_jenis_menu.index'); 
    Route::post('sub_jenis_menu/action','action')->name('action.sub_jenis_menu');
});
//Master Modal Tipe
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\ModalTipeController::class,'middleware' => ['auth','web']], function()
{
    Route::get('modal_tipe','index')->name('modal_tipe.index');
    Route::post('modal_tipe/action','action')->name('action.modal_tipe');
});
//Master Pajak
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\PajakController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_pajak','index')->name('m_pajak.index');
    Route::post('m_pajak/action','action')->name('action.m_pajak');
});
//Master Service Charge
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\SCController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_sc','index')->name('m_sc.index');
    Route::post('m_sc/action','action')->name('action.m_sc');
});
//Master Jenis Meja
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\JenisMejaController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_jenis_meja','index')->name('m_jenis_meja.index');
    Route::post('m_jenis_meja/action','action')->name('action.m_jenis_meja');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
