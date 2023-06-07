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
        $data = new \stdClass ();
        $user = Auth::user()->users_id;
        $waroeng_id = Auth::user()->waroeng_id;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', Auth::user()->waroeng_id)
            ->whereNotIn('m_gudang_nama', ['gudang produksi waroeng'])
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
        $terbayar = (empty($request->rekap_beli_terbayar)) ? 0 : $request->rekap_beli_terbayar;
        $ongkir = (empty($request->rekap_beli_ongkir)) ? 0 : $request->rekap_beli_ongkir;
        $m_w_asal = DB::table('m_w')->where('m_w_id', Auth::user()->waroeng_id)->first();
        $m_w_tujuan = DB::table('m_w')->where('m_w_id', $request->waroeng_tujuan)->first();
        $gudang_tujuan = DB::table('m_gudang')
            ->where('m_gudang_nama', $request->nama_gudang)
            ->where('m_gudang_m_w_id', $request->waroeng_tujuan)->first();
        $rekap_beli = array(
            'rekap_beli_id' => $this->getMasterId('rekap_beli'),
            'rekap_beli_code' => $request->rekap_beli_code,
            'rekap_beli_code_nota' => $request->rekap_beli_code_nota,
            'rekap_beli_tgl' => $request->rekap_beli_tgl,
            'rekap_beli_jth_tmp' => $request->rekap_beli_jth_tmp,
            'rekap_beli_supplier_code' => $m_w_asal->m_w_code,
            'rekap_beli_supplier_nama' => $m_w_asal->m_w_nama,
            'rekap_beli_supplier_telp' => null,
            'rekap_beli_supplier_alamat' => $m_w_asal->m_w_alamat,
            'rekap_beli_m_w_id' => $request->waroeng_tujuan,
            'rekap_beli_gudang_code' => $gudang_tujuan->m_gudang_code,
            'rekap_beli_waroeng' => $m_w_tujuan->m_w_nama,
            'rekap_beli_disc' => $request->rekap_beli_disc,
            'rekap_beli_disc_rp' => convertfloat($request->rekap_beli_disc_rp),
            'rekap_beli_ppn' => $request->rekap_beli_ppn,
            'rekap_beli_ppn_rp' => convertfloat($request->rekap_beli_ppn_rp),
            'rekap_beli_ongkir' => convertfloat($ongkir),
            'rekap_beli_terbayar' => convertfloat($terbayar),
            'rekap_beli_tersisa' => convertfloat($request->rekap_beli_tersisa),
            'rekap_beli_tot_nom' => convertfloat($request->rekap_beli_tot_nom),
            'rekap_beli_ket' => 'dari' . $request->distributor,
            'rekap_beli_created_at' => Carbon::now(),
            'rekap_beli_created_by' => Auth::user()->users_id,
        );

        $insert = DB::table('rekap_beli')->insert($rekap_beli);
        foreach ($request->rekap_beli_detail_qty as $key => $value) {
            $stok_tujuan = DB::table('m_stok')
                ->where('m_stok_m_produk_code', $request->rekap_beli_detail_m_produk_id[$key])
                ->where('m_stok_gudang_code', $gudang_tujuan->m_gudang_code)
                ->first();
            $data = array(
                'rekap_beli_detail_id' => $this->getMasterId('rekap_beli_detail'),
                'rekap_beli_detail_rekap_beli_code' => $request->rekap_beli_code,
                'rekap_beli_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_id[$key],
                'rekap_beli_detail_m_produk_nama' => $stok_tujuan->m_stok_produk_nama,
                'rekap_beli_detail_satuan_id' => $stok_tujuan->m_stok_satuan_id,
                'rekap_beli_detail_satuan_terima' => $stok_tujuan->m_stok_satuan,
                'rekap_beli_detail_catatan' => $request->rekap_beli_detail_catatan[$key],
                'rekap_beli_detail_qty' => convertfloat($request->rekap_beli_detail_qty[$key]),
                'rekap_beli_detail_harga' => convertfloat($request->rekap_beli_detail_harga[$key]),
                'rekap_beli_detail_disc' => $request->rekap_beli_detail_disc[$key],
                'rekap_beli_detail_discrp' => convertfloat($request->rekap_beli_detail_discrp[$key]),
                'rekap_beli_detail_subtot' => convertfloat($request->rekap_beli_detail_subtot[$key]),
                'rekap_beli_detail_m_w_id' => $request->waroeng_tujuan,
                'rekap_beli_detail_created_by' => Auth::user()->users_id,
                'rekap_beli_detail_created_at' => Carbon::now(),
            );
            DB::table('rekap_beli_detail')->insert($data);

            //update keluar dari asal gudang
            $stok_asal = DB::table('m_stok')
                ->where('m_stok_m_produk_code', $request->rekap_beli_detail_m_produk_id[$key])
                ->where('m_stok_gudang_code', $request->asal_gudang)
                ->first();
            $stok_detail = array(
                'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
                'm_stok_detail_code' => $this->getNextId('m_stok_detail', $m_w_asal->m_w_id),
                'm_stok_detail_tgl' => Carbon::now(),
                'm_stok_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_id[$key],
                'm_stok_detail_m_produk_nama' => $stok_asal->m_stok_produk_nama,
                'm_stok_detail_satuan_id' => $stok_asal->m_stok_satuan_id,
                'm_stok_detail_satuan' => $stok_asal->m_stok_satuan,
                'm_stok_detail_gudang_code' => $request->asal_gudang,
                'm_stok_detail_keluar' => convertfloat($request->rekap_beli_detail_qty[$key]),
                'm_stok_detail_saldo' => $stok_asal->m_stok_saldo - convertfloat($request->rekap_beli_detail_qty[$key]),
                'm_stok_detail_hpp' => $stok_asal->m_stok_hpp,
                'm_stok_detail_catatan' => 'penjualan ke ' . $m_w_tujuan->m_w_nama . ' ' . $request->rekap_beli_code,
                'm_stok_detail_created_by' => Auth::user()->users_id,
                'm_stok_detail_created_at' => Carbon::now(),
            );
            DB::table('m_stok_detail')->insert($stok_detail);
            DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->asal_gudang)
                ->where('m_stok_m_produk_code', $request->rekap_beli_detail_m_produk_id[$key])
                ->update(
                    ['m_stok_keluar' => $stok_asal->m_stok_keluar + convertfloat($request->rekap_beli_detail_qty[$key]),
                        'm_stok_saldo' => $stok_asal->m_stok_saldo - convertfloat($request->rekap_beli_detail_qty[$key]),
                        'm_stok_status_sync' => 'send',
                    ]);
        }

        return redirect()->back()->with('success', 'your message,here');
    }
    public function hist_penj_g()
    {
        $tgl_now = Carbon::now();
        $waroeng_id = Auth::user()->waroeng_id;
        $rekap_beli = DB::table('rekap_beli')
            ->join('users', 'rekap_beli_created_by', 'users_id')
            ->where('rekap_beli_tgl', $tgl_now)
            ->where('rekap_beli_supplier_code', sprintf("%03d", $waroeng_id))
            ->orderBy('rekap_beli_created_at', 'desc')
            ->get();

        $data = array();
        $no = 1;
        foreach ($rekap_beli as $value) {
            $row = array();
            $row[] = $no;
            $row[] = $value->rekap_beli_code;
            $row[] = rupiah($value->rekap_beli_tot_nom);
            $row[] = ucwords($value->rekap_beli_waroeng);
            $row[] = ucwords($value->name);
            $row[] = tgl_waktuid($value->rekap_beli_created_at);
            $row[] = '<a id="detail" class="btn btn-sm detail btn-warning" value="' . $value->rekap_beli_code . '" title="Edit"><i class="fa fa-eye"></i></a>';
            $data[] = $row;
            $no++;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
