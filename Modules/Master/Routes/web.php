<?php

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

//Master Area Route
use illuminate\Support\Facades\Route;
use Modules\Master\Http\Controllers\MTipeNotaController;
use Modules\Master\Http\Controllers\MWaroengController;

Route::group(['prefix' => 'master', 'controller' => MAreaController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('area', 'index')->name('area.index');
    Route::post('area/action', 'action')->name('action.area');
});
//Master Jenis Route
Route::group(['prefix' => 'master', 'controller' => MJenisMenuController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('jenis_menu', 'index')->name('jenis_menu.index');
    Route::post('jenis_menu/sort', 'sort')->name('sort.jenis_menu');
    Route::post('jenis_menu/action', 'action')->name('action.jenis_menu');
});
//Master SubJenis
Route::group(['prefix' => 'master', 'controller' => SubJenisMController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('sub_jenis_menu', 'index')->name('sub_jenis_menu.index');
    Route::get('sub_jenis_menu/list', 'list')->name('sub_jenis_menu.list');
    Route::post('sub_jenis_menu/action', 'action')->name('action.sub_jenis_menu');
});
//Master Modal Tipe
Route::group(['prefix' => 'master', 'controller' => ModalTipeController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('modal_tipe', 'index')->name('modal_tipe.index');
    Route::post('modal_tipe/action', 'action')->name('action.modal_tipe');
});
//Master Pajak
Route::group(['prefix' => 'master', 'controller' => PajakController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_pajak', 'index')->name('m_pajak.index');
    Route::post('m_pajak/action', 'action')->name('action.m_pajak');
});
//Master Service Charge
Route::group(['prefix' => 'master', 'controller' => SCController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_sc', 'index')->name('m_sc.index');
    Route::post('m_sc/action', 'action')->name('action.m_sc');
});
//Master Jenis Meja
Route::group(['prefix' => 'master', 'controller' => JenisMejaController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_jenis_meja', 'index')->name('m_jenis_meja.index');
    Route::post('m_jenis_meja/action', 'action')->name('action.m_jenis_meja');
});
//Master Trans Tipe
Route::group(['prefix' => 'master', 'controller' => TransTipeController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_transaksi_tipe', 'index')->name('m_transaksi_tipe.index');
    Route::post('m_transaksi_tipe/action', 'action')->name('action.m_transaksi_tipe');
});
//Master Jenis Waroeng
Route::group(['prefix' => 'master', 'controller' => WJenisController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_w_jenis', 'index')->name('m_w_jenis.index');
    Route::post('m_w_jenis/action', 'action')->name('action.m_w_jenis');
});
//Master Waroeng
Route::group(['prefix' => 'master', 'controller' => MWaroengController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_waroeng', 'index')->name('m_waroeng.index');
    Route::get('m_waroeng/edit/{id}', 'edit')->name('m_waroeng.edit');
    Route::post('m_waroeng/action', 'action')->name('action.m_waroeng');
    Route::get('m_waroeng/akses', 'get_mw_akses');
    Route::get('m_waroeng/waroeng_update/{id}', 'update_waroeng_id');
    Route::get('generate-qr-code', 'generateQRCode')->name('generate.qr-code');
});
//Master Jenis Nota
Route::group(['prefix' => 'master', 'controller' => MJenisNotaController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_jenis_nota', 'index')->name('m_jenis_nota.index');
    Route::get('m_jenis_nota/list', 'list')->name('m_jenis_nota.list');
    Route::post('m_jenis_nota/store', 'store')->name('m_jenis_nota.store');
    Route::get('m_jenis_nota/show/{id}', 'show')->name('m_jenis_nota.show');
    Route::get('m_jenis_nota/detail_harga/{id}', 'detailHarga')->name('m_jenis_nota.detail_harga');
    Route::get('m_jenis_nota/show_harga/{id}', 'showHarga')->name('m_jenis_nota.show_harga');
    Route::post('m_jenis_nota/simpan_harga', 'simpanHarga')->name('m_jenis_nota.simpan_harga');
    Route::post('m_jenis_nota/copy', 'copy_nota')->name('m_jenis_nota.copy');
    Route::post('m_jenis_nota/update', 'update_harga')->name('m_jenis_nota.update');
    Route::post('m_jenis_nota/save_update_harga', 'simpanUpdateHarga')->name('m_jenis_nota.save_update_harga');
    Route::get('m_jenis_nota/get_harga', 'get_harga')->name('m_jenis_nota');
});

//Master Meja
Route::group(['prefix' => 'master', 'controller' => MejaController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('meja', 'index')->name('meja.index');
    Route::get('meja/list_meja', 'list_meja')->name('meja.list');
    Route::get('meja/find/{id}', 'find')->name('meja.find');
    Route::post('meja/simpan', 'simpan')->name('simpan.meja');
    Route::get('meja/hapus/{id}', 'hapus')->name('hapus.meja');
    Route::post('meja/edit', 'edit')->name('edit.meja');
});
//Master Satuan
Route::group(['prefix' => 'master', 'controller' => MSatuanController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_satuan', 'index')->name('m_satuan.index');
    Route::post('m_satuan/action', 'action')->name('action.m_satuan');
    Route::get('m_satuan/{id}', 'satuan_kode_produk');
});
//Master Klasifikasi
Route::group(['prefix' => 'master', 'controller' => ProdKlasifikasiController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_klasifikasi', 'index')->name('m_klasifikasi.index');
    Route::post('m_klasifikasi/action', 'action')->name('action.m_klasifikasi');
});
//Master Footer
Route::group(['prefix' => 'master', 'controller' => FooterController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('conf_footer', 'index')->name('conf_footer.index');
    Route::get('conf_footer/list', 'list')->name('conf_footer.list');
    Route::post('conf_footer/action', 'action')->name('action.conf_footer');
});
//Master Produk
Route::group(['prefix' => 'master', 'controller' => ProdukController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_produk', 'index')->name('m_produk.index');
    Route::post('produk/simpan', 'simpan')->name('simpan.m_produk');
    Route::get('produk/list/{id}', 'list')->name('m_produk.list');
    Route::get('m_produk_satuan/{id}', 'get_prod_sat');

});
//Master Produk Relasi
Route::group(['prefix' => 'master', 'controller' => RelasiKatMenuController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_produk_relasi', 'index')->name('m_produk_relasi.index');
    Route::post('m_produk_relasi/simpan', 'simpan')->name('simpan.m_produk_relasi');
    Route::post('m_produk_relasi/edit', 'edit')->name('edit.m_produk_relasi');
    Route::get('m_produk_relasi/list/{id}', 'list')->name('m_produk_relasi.list');
    Route::get('m_produk_relasi/hapus/{id}', 'hapus')->name('hapus.m_produk_relasi');
});
//Master Resep
Route::group(['prefix' => 'master', 'controller' => ResepController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_resep', 'index')->name('m_resep.index');
    Route::post('m_resep/simpan', 'simpan')->name('simpan.m_resep');
    Route::post('m_resep/edit', 'edit')->name('edit.m_resep');
    Route::get('m_resep/list/{id}', 'list')->name('m_resep.list');
    Route::get('m_resep/detail/{id}', 'detail')->name('detail.m_resep');
    Route::post('m_resep/action/{id}', 'action')->name('action.m_resep');
    Route::get('m_resep_detail_edit/{id}', 'list_detail')->name('resep_detail_edit.m_resep');
});
//Master Tipe Waroeng
Route::group(['prefix' => 'master', 'controller' => MTipeNotaController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('m_tipe_nota', 'index')->name('m_tipe_nota.index');
    Route::post('m_tipe_nota/action', 'action')->name('action.m_tipe_nota');
});
//Master Pajak
Route::group(['prefix' => 'master', 'controller' => PajakCollectionController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('pajak', 'index')->name('pajak.index');
    Route::post('pajak/action', 'action')->name('action.pajak_collection');
});
//Status Menu
Route::group(['prefix' => 'master', 'controller' => StatusMenuController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('status_menu', 'index')->name('status_menu.index');
    Route::get('status_menu/select_waroeng', 'select_waroeng')->name('status_menu.select_waroeng');
    Route::get('status_menu/show', 'show')->name('status_menu.show');
    Route::get('status_menu/client_target/{id}', 'client_target')->name('status_menu.client_target');
    Route::get('status_menu/client_target_show/{id}', 'client_target_show')->name('client_target_show.detail_show_laci');

});
//Compare Menu
Route::group(['prefix' => 'master', 'controller' => CompareMenuController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('compare_menu', 'index')->name('compare_menu.index');
    Route::get('compare_menu/select_waroeng', 'select_waroeng')->name('compare_menu.select_waroeng');
    Route::get('compare_menu/show', 'show')->name('compare_menu.show');
});
// QR Menu
Route::group(['prefix' => 'qr', 'controller' => ProdukController::class, 'middleware' => ['auth', 'web']], function () {
    Route::get('menu', 'menu')->name('qr.menu');
    Route::get('get_menu', 'be_get_menu')->name('qr.be_get_menu');
    Route::post('menu_update', 'be_menu_update')->name('qr.be_menu_update');
});
