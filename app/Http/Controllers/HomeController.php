<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $get_trans = DB::table('log_transaksi_cr')->limit(5)->get();
        // foreach ($get_trans as $key) {
        //     $get_trans_m_w = DB::table('rekap_transaksi')->where('r_t_id', $key->log_transaksi_cr_r_t_id)->value('r_t_m_w_id');
        //     $get_trans_detail = DB::table('rekap_transaksi_detail')
        //         ->where('r_t_detail_r_t_id', $key->log_transaksi_cr_r_t_id)->get();
        //     foreach ($get_trans_detail as $val) {
        //         $get_resep = DB::table('m_resep')
        //             ->join('m_resep_detail', 'm_resep_code', 'm_resep_detail_m_resep_code')
        //             ->where('m_resep_m_produk_code', $val->r_t_detail_m_produk_code)
        //             ->whereNotNull('m_resep_detail_standar_porsi')
        //             ->get();
        //         foreach ($get_resep as $val2) {
        //             $get_std_resep = DB::table('m_std_bb_resep')->where('m_std_bb_resep_m_produk_code', $val2->m_resep_detail_bb_code)->first();
        //             if (empty($get_std_resep)) {
        //                 $qty = $val->r_t_detail_qty;
        //             } else {
        //                 $qty = ($val->r_t_detail_qty * $val2->m_resep_detail_bb_qty) / $get_std_resep->m_std_bb_resep_qty;
        //             }
        //             $get_gudang_code = DB::table('m_gudang')
        //                 ->where('m_gudang_nama', 'gudang produksi waroeng')
        //                 ->where('m_gudang_m_w_id', $get_trans_m_w)->value('m_gudang_code');
        //             $get_stok = $this->get_last_stok($get_gudang_code, $val2->m_resep_detail_bb_code);
        //             $update_stok = DB::table('m_stok')
        //                 ->where('m_stok_gudang_code', $get_gudang_code)
        //                 ->where('m_stok_m_produk_code', $val2->m_resep_detail_bb_code)
        //                 ->update(['m_stok_saldo' => $get_stok->m_stok_saldo - $qty,
        //                     'm_stok_keluar' => $get_stok->m_stok_keluar + $qty,
        //                     'm_stok_updated_at' => Carbon::now()]);
        //             $stok_detail = array(
        //                 'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
        //                 'm_stok_detail_code' => $this->getNextId('m_stok_detail', $get_trans_m_w),
        //                 'm_stok_detail_tgl' => Carbon::now(),
        //                 'm_stok_detail_m_produk_code' => $val2->m_resep_detail_bb_code,
        //                 'm_stok_detail_m_produk_nama' => $get_stok->m_stok_produk_nama,
        //                 'm_stok_detail_satuan_id' => $get_stok->m_stok_satuan_id,
        //                 'm_stok_detail_satuan' => $get_stok->m_stok_satuan,
        //                 'm_stok_detail_gudang_code' => $get_gudang_code,
        //                 'm_stok_detail_keluar' => convertfloat($qty),
        //                 'm_stok_detail_saldo' => $get_stok->m_stok_saldo - convertfloat($qty),
        //                 'm_stok_detail_hpp' => $get_stok->m_stok_hpp,
        //                 'm_stok_detail_catatan' => 'penjualan cr ' . $key->log_transaksi_cr_r_t_id,
        //                 'm_stok_detail_created_by' => 1,
        //                 'm_stok_detail_created_at' => Carbon::now(),
        //             );
        //             DB::table('m_stok_detail')->insert($stok_detail);
        //             $remove_list = DB::table('log_transaksi_cr')
        //             ->where('log_transaksi_cr_r_t_id',$key->log_transaksi_cr_r_t_id)
        //             ->delete();
        //         }

        //     }
        // }
        return view('home');
    }
}
