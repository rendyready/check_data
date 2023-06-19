<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class RusakController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {   $data = new \stdClass();
        $user = Auth::user()->users_id;
        $w_id = Auth::user()->waroeng_id;
        $waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$w_id)->first();
        $data->code = $this->getNextId('rekap_rusak',$w_id); 
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->select('m_gudang_code','m_gudang_nama')
        ->where('m_gudang_m_w_id',$w_id)->get();
        return view('inventori::form_rusak',compact('data','waroeng_nama'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $rekap_rusak = array(
            'rekap_rusak_id' => $request->rekap_rusak_code,
            'rekap_rusak_tgl' => $request->rekap_rusak_tgl,
            'rekap_rusak_m_gudang_code' => $request->m_gudang_code,
            'rekap_rusak_m_w_id' => $waroeng_id,
            'rekap_rusak_m_w_nama' => $this->get_m_w_nama(),
            'rekap_rusak_created_at' => Carbon::now(),
            'rekap_rusak_created_by' => Auth::user()->users_id
        );

        $insert = DB::table('rekap_rusak')->insert($rekap_rusak);
        foreach ($request->rekap_rusak_detail_qty as $key => $value) {
            $produk = DB::table('m_produk')
            ->where('m_produk_code',$request->rekap_rusak_detail_m_produk_id[$key])
            ->first();
            $data = array(
                'rekap_rusak_detail_id' => $this->getNextId('rekap_rusak_detail',$waroeng_id),
                'rekap_rusak_detail_rekap_rusak_id'=> $request->rekap_rusak_code,
                'rekap_rusak_detail_gudang_code' => $request->m_gudang_code,
                'rekap_rusak_detail_m_produk_code' => $request->rekap_rusak_detail_m_produk_id[$key],
                'rekap_rusak_detail_m_produk_nama' => $produk->m_produk_nama,
                'rekap_rusak_detail_qty' => convertfloat($request->rekap_rusak_detail_qty[$key]),
                'rekap_rusak_detail_hpp' => convertfloat($request->rekap_rusak_detail_hpp[$key]),
                'rekap_rusak_detail_satuan' => $request->satuan[$key],
                'rekap_rusak_detail_sub_total' => convertfloat($request->rekap_rusak_detail_sub_total[$key]),
                'rekap_rusak_detail_catatan' => $request->rekap_rusak_detail_catatan[$key],
                'rekap_rusak_detail_created_by' => Auth::user()->users_id,
                'rekap_rusak_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_rusak_detail')->insert($data);

            $data_stok = DB::table('m_stok')
            ->where('m_stok_gudang_code',$request->m_gudang_code)
            ->where('m_stok_m_produk_code',$request->rekap_rusak_detail_m_produk_id[$key])
            ->first();
            $data2 = array( 
                            'm_stok_keluar' => $data_stok->m_stok_keluar+$request->rekap_rusak_detail_qty[$key],
                            'm_stok_saldo' => $data_stok->m_stok_saldo-$request->rekap_rusak_detail_qty[$key],
                            'm_stok_rusak' => $data_stok->m_stok_rusak+$request->rekap_rusak_detail_qty[$key]
                        );
            DB::table('m_stok')->where('m_stok_gudang_code',$request->m_gudang_code)
            ->where('m_stok_m_produk_code',$request->rekap_rusak_detail_m_produk_id[$key])
            ->update($data2);

            $input_detail = array(
                'm_stok_detail_id' => $this->getNextId('m_stok_detail',$waroeng_id),
                'm_stok_detail_m_produk_code' => $request->rekap_rusak_detail_m_produk_id[$key],
                'm_stok_detail_tgl'=> Carbon::now(),
                'm_stok_detail_m_produk_nama' => $produk->m_produk_nama,
                'm_stok_detail_satuan_id' => $data_stok->m_stok_satuan_id,
                'm_stok_detail_satuan' => $data_stok->m_stok_satuan,
                'm_stok_detail_keluar' => $request->rekap_rusak_detail_qty[$key],
                'm_stok_detail_saldo' => $data_stok->m_stok_saldo - $request->rekap_rusak_detail_qty[$key],
                'm_stok_detail_hpp' => $data_stok->m_stok_hpp,
                'm_stok_detail_catatan' => 'rusak '.$request->rekap_rusak_code,
                'm_stok_detail_gudang_code' => $request->m_gudang_code,
                'm_stok_detail_created_by' => Auth::user()->users_id,
                'm_stok_detail_created_at' => Carbon::now()
            );
            DB::table('m_stok_detail')->insert($input_detail);
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }
    public function rusak_daily_list($id) {
        $list = DB::table('rekap_rusak')
        ->join('rekap_rusak_detail','rekap_rusak_id','rekap_rusak_detail_rekap_rusak_id')
        ->join('users','users_id','rekap_rusak_created_by')
        ->where('rekap_rusak_m_gudang_code',$id)
        ->where('rekap_rusak_tgl',Carbon::now())
        ->get();
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $row[] = tgl_waktuid($value->rekap_rusak_created_at);
            $row[] = $value->rekap_rusak_id;
            $row[] = $value->rekap_rusak_detail_m_produk_nama;
            $row[] = $value->rekap_rusak_detail_qty;
            $row[] = $value->rekap_rusak_detail_satuan;
            $row[] = ucwords($value->name);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

}
