<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $user = Auth::user()->users_id;
        $waroeng_id = Auth::user()->waroeng_id;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', Auth::user()->waroeng_id)
            ->whereNotIn('m_gudang_nama', ['gudang wbd waroeng'])
            ->get();
        $data->waroeng = DB::table('m_w')->select('m_w_id', 'm_w_nama')->get();
        $data->supplier = DB::table('m_supplier')->get();
        return view('inventori::form_penjualan_internal', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $terbayar = (empty($request->r_t_jb_terbayar)) ? 0 : $request->r_t_jb_terbayar;
        $ongkir = (empty($request->r_t_jb_ongkir)) ? 0 : $request->r_t_jb_ongkir;
        $id_waroeng = Auth::user()->waroeng_id;
        $m_w_asal = DB::table('m_w')->where('m_w_id',$id_waroeng)->first();
        $m_w_tujuan = DB::table('m_w')->where('m_w_id', $request->waroeng_tujuan)->first();
        $gudang_tujuan = DB::table('m_gudang')
            ->where('m_gudang_nama', $request->nama_gudang)
            ->where('m_gudang_m_w_id', $request->waroeng_tujuan)->first();
            $area = $this->getAreaMw($id_waroeng);
            $terbayar = (empty($request->r_t_jb_terbayar)) ? 0 : $request->r_t_jb_terbayar;
            $ongkir = (empty($request->r_t_jb_ongkir)) ? 0 : $request->r_t_jb_ongkir;
        $r_t_jb = array(
            'r_t_jb_id' => $request->r_t_jb_code,
            'r_t_jb_code_nota' => $request->r_t_jb_code_nota,
            'r_t_jb_tgl' => $request->r_t_jb_tgl,
            'r_t_jb_jth_tmp' => $request->r_t_jb_jth_tmp,
            'r_t_jb_type' => 'transfer',
            'r_t_jb_m_gudang_code_asal' => $request->asal_gudang,
            'r_t_jb_m_gudang_code_tujuan' => $request->r_t_jb_m_gudang_code,
            'r_t_jb_m_supplier_code' => $request->r_t_jb_m_supplier_code,
            'r_t_jb_m_supplier_nama' => $request->r_t_jb_m_supplier_nama,
            'r_t_jb_m_supplier_telp' => $request->r_t_jb_m_supplier_telp,
            'r_t_jb_m_supplier_alamat' => $request->r_t_jb_m_supplier_alamat,
            'r_t_jb_m_w_id_asal' => $id_waroeng,
            'r_t_jb_m_w_nama_asal' => $request->r_t_jb_waroeng,
            'r_t_jb_m_w_id_tujuan' => $id_waroeng,
            'r_t_jb_m_w_nama_tujuan' => $request->r_t_jb_waroeng,
            'r_t_jb_m_area_code_asal' => $area->m_area_code,
            'r_t_jb_m_area_nama_asal' => $area->m_area_nama,
            'r_t_jb_m_area_code_tujuan' => $area->m_area_code,
            'r_t_jb_m_area_nama_tujuan' => $area->m_area_nama,
            'r_t_jb_sub_total_beli' => convertfloat($request->r_t_jb_sub_total_beli),
            'r_t_jb_disc' => $request->r_t_jb_disc,
            'r_t_jb_nominal_disc' => convertfloat($request->r_t_jb_nominal_disc),
            'r_t_jb_ppn' => $request->r_t_jb_ppn,
            'r_t_jb_nominal_ppn' => convertfloat($request->r_t_jb_nominal_ppn),
            'r_t_jb_nominal_ongkir' => convertfloat($ongkir),
            'r_t_jb_nominal_total_beli' => convertfloat($request->r_t_jb_nominal_total_beli),
            'r_t_jb_nominal_bayar' => 0,
            'r_t_jb_ket' => 'pembelian mandiri',
            'r_t_jb_created_at' => Carbon::now(),
            'r_t_jb_created_by' => Auth::user()->users_id,
        );
        return $r_t_jb;

        $insert = DB::table('r_t_jb')->insert($r_t_jb);
        foreach ($request->r_t_jb_detail_qty as $key => $value) {
            $stok_tujuan = DB::table('m_stok')
                ->where('m_stok_m_produk_code', $request->r_t_jb_detail_m_produk_id[$key])
                ->where('m_stok_gudang_code', $gudang_tujuan->m_gudang_code)
                ->first();
            $data = array(
                'r_t_jb_detail_id' => $this->getMasterId('r_t_jb_detail'),
                'r_t_jb_detail_r_t_jb_code' => $request->r_t_jb_code,
                'r_t_jb_detail_m_produk_code' => $request->r_t_jb_detail_m_produk_id[$key],
                'r_t_jb_detail_m_produk_nama' => $stok_tujuan->m_stok_produk_nama,
                'r_t_jb_detail_satuan_id' => $stok_tujuan->m_stok_satuan_id,
                'r_t_jb_detail_satuan_terima' => $stok_tujuan->m_stok_satuan,
                'r_t_jb_detail_catatan' => $request->r_t_jb_detail_catatan[$key],
                'r_t_jb_detail_qty' => convertfloat($request->r_t_jb_detail_qty[$key]),
                'r_t_jb_detail_harga' => convertfloat($request->r_t_jb_detail_harga[$key]),
                'r_t_jb_detail_disc' => $request->r_t_jb_detail_disc[$key],
                'r_t_jb_detail_discrp' => convertfloat($request->r_t_jb_detail_discrp[$key]),
                'r_t_jb_detail_subtot' => convertfloat($request->r_t_jb_detail_subtot[$key]),
                'r_t_jb_detail_m_w_id' => $request->waroeng_tujuan,
                'r_t_jb_detail_created_by' => Auth::user()->users_id,
                'r_t_jb_detail_created_at' => Carbon::now(),
            );
            DB::table('r_t_jb_detail')->insert($data);

            //update keluar dari asal gudang
            $stok_asal = DB::table('m_stok')
                ->where('m_stok_m_produk_code', $request->r_t_jb_detail_m_produk_id[$key])
                ->where('m_stok_gudang_code', $request->asal_gudang)
                ->first();
            $stok_detail = array(
                'm_stok_detail_id' => $this->getNextId('m_stok_detail', $m_w_asal->m_w_id),
                'm_stok_detail_tgl' => Carbon::now(),
                'm_stok_detail_m_produk_code' => $request->r_t_jb_detail_m_produk_id[$key],
                'm_stok_detail_m_produk_nama' => $stok_asal->m_stok_produk_nama,
                'm_stok_detail_satuan_id' => $stok_asal->m_stok_satuan_id,
                'm_stok_detail_satuan' => $stok_asal->m_stok_satuan,
                'm_stok_detail_gudang_code' => $request->asal_gudang,
                'm_stok_detail_keluar' => convertfloat($request->r_t_jb_detail_qty[$key]),
                'm_stok_detail_saldo' => $stok_asal->m_stok_saldo - convertfloat($request->r_t_jb_detail_qty[$key]),
                'm_stok_detail_hpp' => $stok_asal->m_stok_hpp,
                'm_stok_detail_catatan' => 'penjualan ke ' . $m_w_tujuan->m_w_nama . ' ' . $request->r_t_jb_code,
                'm_stok_detail_created_by' => Auth::user()->users_id,
                'm_stok_detail_created_at' => Carbon::now(),
            );
            DB::table('m_stok_detail')->insert($stok_detail);
            DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->asal_gudang)
                ->where('m_stok_m_produk_code', $request->r_t_jb_detail_m_produk_id[$key])
                ->update(
                    ['m_stok_keluar' => $stok_asal->m_stok_keluar + convertfloat($request->r_t_jb_detail_qty[$key]),
                        'm_stok_saldo' => $stok_asal->m_stok_saldo - convertfloat($request->r_t_jb_detail_qty[$key]),
                        'm_stok_status_sync' => 'send',
                    ]);
        }

        return redirect()->back()->with('success', 'your message,here');
    }
    public function hist_penj_g()
    {
        $tgl_now = Carbon::now();
        $waroeng_id = Auth::user()->waroeng_id;
        $r_t_jb = DB::table('r_t_jb')
            ->join('users', 'r_t_jb_created_by', 'users_id')
            ->where('r_t_jb_tgl', $tgl_now)
            ->where('r_t_jb_supplier_code', sprintf("%03d", $waroeng_id))
            ->orderBy('r_t_jb_created_at', 'desc')
            ->get();

        $data = array();
        $no = 1;
        foreach ($r_t_jb as $value) {
            $row = array();
            $row[] = $no;
            $row[] = $value->r_t_jb_code;
            $row[] = rupiah($value->r_t_jb_tot_nom);
            $row[] = ucwords($value->r_t_jb_waroeng);
            $row[] = ucwords($value->name);
            $row[] = tgl_waktuid($value->r_t_jb_created_at);
            $row[] = '<a id="detail" class="btn btn-sm detail btn-warning" value="' . $value->r_t_jb_code . '" title="Edit"><i class="fa fa-eye"></i></a>';
            $data[] = $row;
            $no++;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
