<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChtController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {$waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $waroeng_id)->get();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        return view('inventori::form_cht', compact('data'));
    }
    public function simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        foreach ($request->r_t_jb_detail_id as $key => $value) {
            if (!empty($request->r_t_jb_detail_terima_qty[$key])) {
                $cht_qty = convertfloat($request->r_t_jb_detail_terima_qty[$key]);
                $save_beli = DB::table('rekap_trans_jualbeli_detail')
                    ->where('r_t_jb_detail_id', $request->r_t_jb_detail_id[$key])
                    ->update(['r_t_jb_detail_terima_qty' => $cht_qty]);

                $get_stok = $this->get_last_stok($request->rekap_beli_gudang_code, $request->r_t_jb_detail_m_produk_code[$key]);
                $saldo_terakhir = $get_stok->m_stok_saldo;
                $hpp_terakhir = $get_stok->m_stok_hpp;
                $data_masuk = $cht_qty;
                $hpp_now = ($request->r_t_jb_detail_subtot[$key] + ($saldo_terakhir * $hpp_terakhir)) / ($saldo_terakhir + $data_masuk);
                $data = array(
                    'm_stok_detail_id' => $this->getNextId('m_stok_detail', $waroeng_id),
                    'm_stok_detail_m_produk_code' => $request->r_t_jb_detail_m_produk_code[$key],
                    'm_stok_detail_tgl' => Carbon::now(),
                    'm_stok_detail_m_produk_nama' => $get_stok->m_stok_produk_nama,
                    'm_stok_detail_satuan_id' => $get_stok->m_stok_satuan_id,
                    'm_stok_detail_satuan' => $get_stok->m_stok_satuan,
                    'm_stok_detail_masuk' => $data_masuk,
                    'm_stok_detail_saldo' => $saldo_terakhir + $data_masuk,
                    'm_stok_detail_hpp' => $hpp_now,
                    'm_stok_detail_catatan' => 'pembelian ' . $request->r_t_jb_detail_rekap_beli_code[$key],
                    'm_stok_detail_gudang_code' => $request->rekap_beli_gudang_code,
                    'm_stok_detail_created_by' => Auth::user()->users_id,
                    'm_stok_detail_created_at' => Carbon::now(),
                );
                DB::table('m_stok_detail')->insert($data);

                $data2 = array('m_stok_hpp' => $hpp_now,
                    'm_stok_masuk' => $get_stok->m_stok_masuk + $cht_qty,
                    'm_stok_saldo' => $get_stok->m_stok_saldo + $cht_qty,
                    'm_stok_status_sync' => 'edit',
                );
                DB::table('m_stok')->where('m_stok_gudang_code', $request->rekap_beli_gudang_code)
                    ->where('m_stok_m_produk_code', $request->r_t_jb_detail_m_produk_code[$key])
                    ->update($data2);
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function list(Request $request)
    {
        $data = new \stdClass();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $waroeng_id = Auth::user()->waroeng_id;
        $cht = DB::table('rekap_trans_jualbeli_detail')
            ->selectRaw('
        CASE
            WHEN r_t_jb_m_supplier_nama IS NOT NULL THEN r_t_jb_m_supplier_nama
            ELSE r_t_jb_m_w_nama_asal
        END AS nama_supplier
        ,r_t_jb_detail_id,r_t_jb_detail_m_produk_code,r_t_jb_detail_subtot_beli,
        r_t_jb_tgl,r_t_jb_detail_m_produk_nama,r_t_jb_detail_catatan,r_t_jb_detail_qty,r_t_jb_detail_satuan_terima')
            ->leftjoin('rekap_trans_jualbeli', 'r_t_jb_id', 'r_t_jb_detail_r_t_jb_id')
            ->where('r_t_jb_m_gudang_code_tujuan', $request->id)
            ->whereNull('r_t_jb_detail_terima_qty')
            ->orderBy('nama_supplier', 'asc')
            ->get();
        $no = 0;
        $data = array();
        foreach ($cht as $item) {
            $row = array();
            $no++;
            $row[] = $no . '<input type="hidden" class="form-control form-control-sm" name="r_t_jb_detail_id[]" id="r_t_jb_detail_id" value="' . $item->r_t_jb_detail_id . '" > ' .
            '<input type="hidden"  class="form-control form-control-sm" name="r_t_jb_detail_r_t_jb_id[]" id="r_t_jb_detail_rekap_beli_code" value="' . $item->r_t_jb_detail_id . '" >' .
            '<input type="hidden"  class="form-control form-control-sm" name="r_t_jb_detail_m_produk_code[]" id="r_t_jb_detail_m_produk_code" value="' . $item->r_t_jb_detail_m_produk_code . '" >' .
            '<input type="hidden"  class="form-control form-control-sm" name="r_t_jb_detail_subtot_beli[]" id="r_t_jb_detail_subtot_beli" value="' . $item->r_t_jb_detail_subtot_beli . '" >';
            $row[] = tgl_indo($item->r_t_jb_tgl);
            $row[] = $item->nama_supplier;
            $row[] = $item->r_t_jb_detail_m_produk_nama;
            $row[] = $item->r_t_jb_detail_catatan;
            $row[] = convertindo($item->r_t_jb_detail_qty);
            $row[] = '<input type="text" class="form-control number form-control-sm" name="r_t_jb_detail_terima_qty[]" id="r_t_jb_detail_terima_qty">';
            $row[] = ucwords($item->r_t_jb_detail_satuan_terima);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
