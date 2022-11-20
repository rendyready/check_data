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
    Route::get('sub_jenis_menu','index')->name('sub_jenis_menu.index');  Route::get('sub_jenis_menu/list','list')->name('sub_jenis_menu.list');
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
//Master Trans Tipe
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\TransTipeController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_transaksi_tipe','index')->name('m_transaksi_tipe.index');
    Route::post('m_transaksi_tipe/action','action')->name('action.m_transaksi_tipe');
});
//Master Jenis Waroeng
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\WJenisController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_w_jenis','index')->name('m_w_jenis.index');
    Route::post('m_w_jenis/action','action')->name('action.m_w_jenis');
});
//Master Waroeng
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MWaroengController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_waroeng','index')->name('m_waroeng.index'); Route::get('m_waroeng/list','list')->name('m_waroeng.list');
    Route::post('m_waroeng/action','action')->name('action.m_waroeng');
});
//Master Jenis Nota
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MJenisNotaController::class,'middleware' => ['auth','web']], function()
{
    Route::get('m_jenis_nota','index')->name('m_jenis_nota.index'); Route::get('m_jenis_nota/list','list')->name('m_jenis_nota.list');
    Route::post('m_jenis_nota/store','store')->name('store.m_jenis_nota');
});
//Master Footer
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\FooterController::class,'middleware' => ['auth','web']], function()
{
    Route::get('conf_footer','index')->name('conf_footer.index'); Route::get('conf_footer/list','list')->name('conf_footer.list');
    Route::post('conf_footer/action','action')->name('action.conf_footer');
});
//Master Meja
Route::group(['prefix' => 'master', 'controller' => App\Http\Controllers\Master\MejaController::class,'middleware' => ['auth','web']], function()
{
    Route::get('meja','index')->name('meja.index'); Route::get('meja/list','list')->name('meja.list');
    Route::post('meja/action','action')->name('action.meja');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
