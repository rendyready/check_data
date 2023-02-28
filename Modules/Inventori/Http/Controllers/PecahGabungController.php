<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PecahGabungController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {$get_max_id = DB::table('rekap_pcb')->orderBy('rekap_pcb_code', 'desc')->first();
        $waroeng_id = Auth::user()->waroeng_id;
        $gudang_default = DB::table('m_gudang')->select('m_gudang_id')
            ->where('m_gudang_m_w_id', $waroeng_id)->where('m_gudang_nama', 'gudang utama waroeng')->first()->m_gudang_id;
        $gudang_id = (empty($request->gudang_id)) ? $gudang_default : $request->gudang_id;
        $user = Auth::id();
        $data = new \stdClass();
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $waroeng_id)
            ->whereNotIn('m_gudang_nama', ['gudang produksi waroeng'])->get();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        $data->code = $this->getNextId('rekap_pcb', $waroeng_id);
        return view('inventori::form_pcb', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        //insert hasil produk
        if ($request->rekap_pcb_aksi == 'pecah') {
            foreach ($request->rekap_pcb_brg_hasil_code as $key => $value) {
                $hpp_perbrg_asal = ($request->rekap_pcb_brg_asal_hppisi[$key] * $request->rekap_pcb_brg_asal_qty[$key]);
                $hpp_hasil = ($hpp_perbrg_asal / $request->rekap_pcb_brg_hasil_qty[$key]);
                $data = array(
                    'rekap_pcb_code' => $request->rekap_pcb_code,
                    'rekap_pcb_tgl' => Carbon::now(),
                    'rekap_pcb_gudang_asal_code' => $request->rekap_pcb_gudang_asal_code,
                    'rekap_pcb_waroeng' => $request->nama_waroeng,
                    'rekap_pcb_aksi' => $request->rekap_pcb_aksi,
                    'rekap_pcb_brg_asal_code' => $request->rekap_pcb_brg_asal_code[$key],
                    'rekap_pcb_brg_asal_nama' => $request->rekap_pcb_brg_asal_nama[$key],
                    'rekap_pcb_brg_asal_satuan' => $request->rekap_pcb_brg_asal_satuan[$key],
                    // 'rekap_pcb_brg_asal_isi' => $request->rekap_pcb_brg_asal_isi[$key],
                    'rekap_pcb_brg_asal_qty' => $request->rekap_pcb_brg_asal_qty[$key],
                    'rekap_pcb_brg_asal_hppisi' => $hpp_perbrg_asal,
                    'rekap_pcb_brg_hasil_code' => $request->rekap_pcb_brg_hasil_code[$key],
                    'rekap_pcb_brg_hasil_nama' => $request->rekap_pcb_brg_hasil_nama[$key],
                    'rekap_pcb_brg_hasil_satuan' => $request->rekap_pcb_brg_hasil_satuan[$key],
                    // 'rekap_pcb_brg_hasil_isi' => $request->rekap_pcb_brg_hasil_isi[$key],
                    'rekap_pcb_brg_hasil_qty' => $request->rekap_pcb_brg_hasil_qty[$key],
                    'rekap_pcb_brg_hasil_hpp' => $hpp_hasil,
                    'rekap_pcb_created_by' => Auth::id(),
                    'rekap_pcb_created_by_name' => $request->rekap_pcb_created_by_name,
                );
                DB::table('rekap_pcb')->insert($data);
                $get_saldo_hasil = $this->get_last_stok($request->rekap_pcb_gudang_asal_code, $request->rekap_pcb_brg_hasil_code[$key]);
                $saldo_now = $get_saldo_hasil->m_stok_saldo + $request->rekap_pcb_brg_hasil_qty[$key];
                $hpp_now = (($get_saldo_hasil->m_stok_hpp * $get_saldo_hasil->m_stok_saldo) + ($hpp_hasil * $request->rekap_pcb_brg_hasil_qty[$key])) / ($get_saldo_hasil->m_stok_saldo + $request->rekap_pcb_brg_hasil_qty[$key]);
                $stok_detail = array(
                    'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
                    'm_stok_detail_tgl' => Carbon::now(),
                    'm_stok_detail_m_produk_code' => $request->rekap_pcb_brg_hasil_code[$key],
                    'm_stok_detail_m_produk_nama' => $request->rekap_pcb_brg_hasil_nama[$key],
                    'm_stok_detail_gudang_code' => $request->rekap_pcb_gudang_asal_code,
                    'm_stok_detail_masuk' => $request->rekap_pcb_brg_hasil_qty[$key],
                    'm_stok_detail_saldo' => $saldo_now,
                    'm_stok_detail_hpp' => $hpp_now,
                    'm_stok_detail_catatan' => 'masuk pecah ' . $request->rekap_pcb_code,
                    'm_stok_detail_created_by' => Auth::id(),
                    'm_stok_detail_created_at' => Carbon::now(),
                );
                DB::table('m_stok_detail')->insert($stok_detail);
                DB::table('m_stok')
                    ->where('m_stok_gudang_code', $request->rekap_pcb_gudang_asal_code)
                    ->where('m_stok_m_produk_code', $request->rekap_pcb_brg_hasil_code[$key])
                    ->update(
                        ['m_stok_keluar' => $get_saldo_hasil->m_stok_keluar + $request->rekap_pcb_brg_hasil_qty[$key],
                            'm_stok_saldo' => $saldo_now,
                            'm_stok_hpp' => $hpp_now,
                        ]);
            }
            //insert produk asal saja
            $get_saldo_asal = DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->rekap_pcb_gudang_asal_code)
                ->where('m_stok_m_produk_code', $request->rekap_pcb_brg_asal_code[0])
                ->first();
            $saldo_now = $get_saldo_asal->m_stok_saldo - $request->rekap_pcb_brg_asal_qty[0];
            $stok_detail = array(
                'm_stok_detail_id' => $this->getlast('m_stok_detail', 'm_stok_detail_id'),
                'm_stok_detail_tgl' => Carbon::now(),
                'm_stok_detail_m_produk_code' => $request->rekap_pcb_brg_asal_code[0],
                'm_stok_detail_m_produk_nama' => $request->rekap_pcb_brg_asal_nama[0],
                'm_stok_detail_gudang_code' => $request->rekap_pcb_gudang_asal_code,
                'm_stok_detail_keluar' => $request->rekap_pcb_brg_asal_qty[0],
                'm_stok_detail_saldo' => $saldo_now,
                'm_stok_detail_hpp' => $request->rekap_pcb_brg_asal_hppisi[0],
                'm_stok_detail_catatan' => 'keluar pecah' . $request->rekap_pcb_code,
                'm_stok_detail_created_by' => Auth::id(),
                'm_stok_detail_created_at' => Carbon::now(),
            );
            DB::table('m_stok_detail')->insert($stok_detail);
            DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->rekap_pcb_gudang_asal_code)
                ->where('m_stok_m_produk_code', $request->rekap_pcb_brg_asal_code[0])
                ->update(['m_stok_keluar' => $get_saldo_asal->m_stok_keluar + $request->rekap_pcb_brg_asal_qty[0],
                    'm_stok_saldo' => $saldo_now,
                ]);
        } else {
            $jumlah_hpp = array_sum($request->rekap_pcb_brg_asal_hppisi);
            foreach ($request->rekap_pcb_brg_asal_code as $key => $value) {
                // $hpp_hasil = ($hpp_perbrg_asal / $request->rekap_pcb_brg_hasil_qty[$key]);
                $data = array(
                    'rekap_pcb_code' => $request->rekap_pcb_code,
                    'rekap_pcb_tgl' => Carbon::now(),
                    'rekap_pcb_gudang_asal_code' => $request->rekap_pcb_gudang_asal_code,
                    'rekap_pcb_waroeng' => $request->nama_waroeng,
                    'rekap_pcb_aksi' => $request->rekap_pcb_aksi,
                    'rekap_pcb_brg_asal_code' => $request->rekap_pcb_brg_asal_code[$key],
                    'rekap_pcb_brg_asal_nama' => $request->rekap_pcb_brg_asal_nama[$key],
                    'rekap_pcb_brg_asal_satuan' => $request->rekap_pcb_brg_asal_satuan[$key],
                    // 'rekap_pcb_brg_asal_isi' => $request->rekap_pcb_brg_asal_isi[$key],
                    'rekap_pcb_brg_asal_qty' => $request->rekap_pcb_brg_asal_qty[$key],
                    'rekap_pcb_brg_asal_hppisi' => $request->rekap_pcb_brg_asal_hppisi[$key],
                    'rekap_pcb_brg_hasil_code' => $request->rekap_pcb_brg_hasil_code[$key],
                    'rekap_pcb_brg_hasil_nama' => $request->rekap_pcb_brg_hasil_nama[$key],
                    'rekap_pcb_brg_hasil_satuan' => $request->rekap_pcb_brg_hasil_satuan[$key],
                    // 'rekap_pcb_brg_hasil_isi' => $request->rekap_pcb_brg_hasil_isi[$key],
                    'rekap_pcb_brg_hasil_qty' => $request->rekap_pcb_brg_hasil_qty[$key],
                    'rekap_pcb_brg_hasil_hpp' => $jumlah_hpp/$request->rekap_pcb_brg_hasil_qty[$key],
                    'rekap_pcb_created_by' => Auth::id(),
                    'rekap_pcb_created_by_name' => $request->rekap_pcb_created_by_name,
                );
                DB::table('rekap_pcb')->insert($data);
            }
        }

    }

}
