<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ChtController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {   $waroeng_id = Auth::user()->waroeng_id;
        $gudang_default = DB::table('m_gudang')->select('m_gudang_id')
        ->where('m_gudang_m_w_id',$waroeng_id)->where('m_gudang_nama','gudang utama waroeng')->first()->m_gudang_id;
        $gudang_id = (empty($request->gudang_id)) ? $gudang_default : $request->gudang_id ; 
        $data = new \stdClass();
        $data->gudang = DB::table('m_gudang')
        ->where('m_gudang_m_w_id',$waroeng_id)
        ->whereNotIn('m_gudang_nama',['gudang produksi waroeng'])->get();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        return view('inventori::form_cht',compact('data'));
    }
    public function simpan(Request $request)
    {  
        foreach ($request->rekap_beli_detail_id as $key => $value) {
            $save_beli = DB::table('rekap_beli_detail')
                ->where('rekap_beli_detail_id',$request->rekap_beli_detail_id[$key])
                ->update(['rekap_beli_detail_terima_qty'=>$request->rekap_beli_detail_terima_qty[$key]]);
                       
            if (!empty($request->rekap_beli_detail_terima_qty[$key])) {
                 $last_mutasi = DB::table('m_stok_detail')
                ->select('m_stok_detail_hpp','m_stok_detail_saldo')
                ->where('m_stok_detail_gudang_code',$request->rekap_beli_gudang_code)
                ->where('m_stok_detail_m_produk_code',$request->rekap_beli_detail_m_produk_code[$key])
                ->orderBy('m_stok_detail_id','desc')
                ->first();

                $data_stok = DB::table('m_stok')
                ->where('m_stok_gudang_code',$request->rekap_beli_gudang_code)
                ->where('m_stok_m_produk_code',$request->rekap_beli_detail_m_produk_code[$key])
                ->first();

                $saldo_terakhir = (empty($last_mutasi)) ? 0 : $last_mutasi->m_stok_detail_saldo ;
                $hpp_terakhir = (empty($last_mutasi)) ? 0 : $last_mutasi->m_stok_detail_hpp ;
                $data_masuk = $request->rekap_beli_detail_terima_qty[$key];
                $data = array(
                    'm_stok_detail_id' => $this->getlast('m_stok_detail','m_stok_detail_id'),
                    'm_stok_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_code[$key],
                    'm_stok_detail_tgl'=> Carbon::now(),
                    'm_stok_detail_m_produk_nama' => $data_stok->m_stok_produk_nama,
                    'm_stok_detail_satuan_id' => $data_stok->m_stok_satuan_id,
                    'm_stok_detail_satuan' => $data_stok->m_stok_satuan,
                    'm_stok_detail_masuk' => $request->rekap_beli_detail_terima_qty[$key],
                    'm_stok_detail_saldo' => $saldo_terakhir + $request->rekap_beli_detail_terima_qty[$key],
                    'm_stok_detail_hpp' => ($request->rekap_beli_detail_subtot[$key]+($saldo_terakhir*$hpp_terakhir))/($saldo_terakhir+$data_masuk),
                    'm_stok_detail_catatan' => 'Pembelian'.$request->rekap_beli_detail_rekap_beli_code[$key],
                    'm_stok_detail_gudang_code' => $request->rekap_beli_gudang_code,
                    'm_stok_detail_created_by' => Auth::id(),
                    'm_stok_detail_created_at' => Carbon::now()
                );
                DB::table('m_stok_detail')->insert($data);
                $get_detail = DB::table('m_stok_detail')
                ->where('m_stok_detail_gudang_code',$request->rekap_beli_gudang_code)
                ->where('m_stok_detail_m_produk_code',$request->rekap_beli_detail_m_produk_code[$key])
                ->orderBy('m_stok_detail_id','desc')
                ->first();

                $data2 = array( 'm_stok_hpp' => $get_detail->m_stok_detail_hpp,
                                'm_stok_masuk' => $data_stok->m_stok_masuk+ $get_detail->m_stok_detail_masuk,
                                'm_stok_saldo' => $data_stok->m_stok_saldo+$get_detail->m_stok_detail_masuk
                            );
                DB::table('m_stok')->where('m_stok_gudang_code',$request->rekap_beli_gudang_code)
                ->where('m_stok_m_produk_code',$request->rekap_beli_detail_m_produk_code[$key])
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
        $cht = DB::table('rekap_beli_detail')
        ->select('rekap_beli_detail_id','rekap_beli_detail_rekap_beli_code',
                'rekap_beli_detail_m_produk_code','rekap_beli_detail_subtot','rekap_beli_supplier_nama','rekap_beli_detail_m_produk_nama',
                 'rekap_beli_detail_catatan','rekap_beli_detail_qty',
                 'rekap_beli_detail_satuan_terima','rekap_beli_tgl')
        ->leftjoin('rekap_beli','rekap_beli_code','rekap_beli_detail_rekap_beli_code')
        ->where('rekap_beli_m_w_id',$waroeng_id)
        ->where('rekap_beli_gudang_code',$request->id)
        ->whereNull('rekap_beli_detail_terima_qty')
        ->orderBy('rekap_beli_supplier_code','asc')
        ->get();
        $no = 0;
        $data = array();
        foreach ($cht as $item) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = '<input type="text" class="form-control hide form-control-sm" name="rekap_beli_detail_id[]" id="rekap_beli_detail_id" value="'.$item->rekap_beli_detail_id.'" ></td>';
            $row[] = '<input type="text" hide class="form-control form-control-sm" name="rekap_beli_detail_rekap_beli_code[]" id="rekap_beli_detail_rekap_beli_code" value="'.$item->rekap_beli_detail_rekap_beli_code.'" >';
            $row[] = '<input type="text" hide class="form-control form-control-sm" name="rekap_beli_detail_m_produk_code[]" id="rekap_beli_detail_m_produk_code" value="'.$item->rekap_beli_detail_m_produk_code.'" >';
            $row[] = '<input type="text" hide class="form-control form-control-sm" name="rekap_beli_detail_subtot[]" id="rekap_beli_detail_subtot" value="'.$item->rekap_beli_detail_subtot.'" >';
            $row[] = tgl_indo($item->rekap_beli_tgl);
            $row[] = $item->rekap_beli_supplier_nama;
            $row[] = $item->rekap_beli_detail_m_produk_nama;
            $row[] = $item->rekap_beli_detail_catatan;
            $row[] = $item->rekap_beli_detail_qty;
            $row[] = '<input type="number" class="form-control number form-control-sm" name="rekap_beli_detail_terima_qty[]" id="rekap_beli_detail_terima_qty">';
            $row[] = ucwords($item->rekap_beli_detail_satuan_terima);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
