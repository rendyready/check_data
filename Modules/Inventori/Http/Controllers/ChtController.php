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
        $data = new \stdClass ();
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $waroeng_id)
            ->whereNotIn('m_gudang_nama', ['gudang produksi waroeng'])->get();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        return view('inventori::form_cht', compact('data'));
    }
    public function simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        foreach ($request->rekap_beli_detail_id as $key => $value) {
            $cht_qty = convertfloat($request->rekap_beli_detail_terima_qty[$key]);
            $save_beli = DB::table('rekap_beli_detail')
                ->where('rekap_beli_detail_id', $request->rekap_beli_detail_id[$key])
                ->update(['rekap_beli_detail_terima_qty' => $cht_qty,
                    'rekap_beli_detail_status_sync' => 'edit']);

            if (!empty($cht_qty)) {
                $get_stok = $this->get_last_stok($request->rekap_beli_gudang_code, $request->rekap_beli_detail_m_produk_code[$key]);
                $saldo_terakhir = $get_stok->m_stok_saldo;
                $hpp_terakhir = $get_stok->m_stok_hpp;
                $data_masuk = $cht_qty;
                $hpp_now = ($request->rekap_beli_detail_subtot[$key] + ($saldo_terakhir * $hpp_terakhir)) / ($saldo_terakhir + $data_masuk);
                $data = array(
                    'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
                    'm_stok_detail_code' => $this->getNextId('m_stok_detail', $waroeng_id),
                    'm_stok_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_code[$key],
                    'm_stok_detail_tgl' => Carbon::now(),
                    'm_stok_detail_m_produk_nama' => $get_stok->m_stok_produk_nama,
                    'm_stok_detail_satuan_id' => $get_stok->m_stok_satuan_id,
                    'm_stok_detail_satuan' => $get_stok->m_stok_satuan,
                    'm_stok_detail_masuk' => $data_masuk,
                    'm_stok_detail_saldo' => $saldo_terakhir + $data_masuk,
                    'm_stok_detail_hpp' => $hpp_now,
                    'm_stok_detail_catatan' => 'pembelian ' . $request->rekap_beli_detail_rekap_beli_code[$key],
                    'm_stok_detail_gudang_code' => $request->rekap_beli_gudang_code,
                    'm_stok_detail_created_by' => Auth::id(),
                    'm_stok_detail_created_at' => Carbon::now(),
                );
                DB::table('m_stok_detail')->insert($data);

                $data2 = array('m_stok_hpp' => $hpp_now,
                    'm_stok_masuk' => $get_stok->m_stok_masuk + $cht_qty,
                    'm_stok_saldo' => $get_stok->m_stok_saldo + $cht_qty,
                    'm_stok_status_sync' => 'edit',
                );
                DB::table('m_stok')->where('m_stok_gudang_code', $request->rekap_beli_gudang_code)
                    ->where('m_stok_m_produk_code', $request->rekap_beli_detail_m_produk_code[$key])
                    ->update($data2);
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    function list(Request $request) {
        $data = new \stdClass ();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $waroeng_id = Auth::user()->waroeng_id;
        $cht = DB::table('rekap_beli_detail')
            ->select('rekap_beli_detail_id', 'rekap_beli_detail_rekap_beli_code',
                'rekap_beli_detail_m_produk_code', 'rekap_beli_detail_subtot', 'rekap_beli_supplier_nama', 'rekap_beli_detail_m_produk_nama',
                'rekap_beli_detail_catatan', 'rekap_beli_detail_qty',
                'rekap_beli_detail_satuan_terima', 'rekap_beli_tgl')
            ->leftjoin('rekap_beli', 'rekap_beli_code', 'rekap_beli_detail_rekap_beli_code')
            ->where('rekap_beli_m_w_id', $waroeng_id)
            ->where('rekap_beli_gudang_code', $request->id)
            ->whereNull('rekap_beli_detail_terima_qty')
            ->orderBy('rekap_beli_supplier_code', 'asc')
            ->get();
        $no = 0;
        $data = array();
        foreach ($cht as $item) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = '<input type="text" class="form-control hide form-control-sm" name="rekap_beli_detail_id[]" id="rekap_beli_detail_id" value="' . $item->rekap_beli_detail_id . '" ></td>';
            $row[] = '<input type="text" hide class="form-control form-control-sm" name="rekap_beli_detail_rekap_beli_code[]" id="rekap_beli_detail_rekap_beli_code" value="' . $item->rekap_beli_detail_rekap_beli_code . '" >';
            $row[] = '<input type="text" hide class="form-control form-control-sm" name="rekap_beli_detail_m_produk_code[]" id="rekap_beli_detail_m_produk_code" value="' . $item->rekap_beli_detail_m_produk_code . '" >';
            $row[] = '<input type="text" hide class="form-control form-control-sm" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot" value="' . $item->rekap_beli_detail_subtot . '" >';
            $row[] = tgl_indo($item->rekap_beli_tgl);
            $row[] = $item->rekap_beli_supplier_nama;
            $row[] = $item->rekap_beli_detail_m_produk_nama;
            $row[] = $item->rekap_beli_detail_catatan;
            $row[] = convertindo($item->rekap_beli_detail_qty);
            $row[] = '<input type="text" class="form-control number form-control-sm" name="rekap_beli_detail_terima_qty[]" id="rekap_beli_detail_terima_qty">';
            $row[] = ucwords($item->rekap_beli_detail_satuan_terima);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
