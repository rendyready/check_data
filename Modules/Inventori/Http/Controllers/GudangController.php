<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng = DB::table('m_w')->select('m_w_id', 'm_w_nama')->get();
        $nama_gudang = DB::table('m_gudang_nama')->get();
        return view('inventori::m_gudang', compact('waroeng', 'nama_gudang'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    function list() {$no = 0;
        $gudang = DB::table('m_gudang')->
            join('m_w', 'm_w_id', 'm_gudang_m_w_id')->get();
        foreach ($gudang as $key) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = $key->m_w_nama;
            // $row[] = '<a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="'.$key->m_gudang_id.'" title="Edit"><i class="fa fa-pencil"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $validate = DB::table('m_gudang')
                    ->where('m_gudang_m_w_id', $request->m_gudang_m_w_id)
                    ->where('m_gudang_nama', strtolower($request->m_gudang_nama))->first();
                $data = array(
                    'm_gudang_m_w_id' => $request->m_gudang_m_w_id,
                    'm_gudang_nama' => strtolower($request->m_gudang_nama),
                    'm_gudang_created_by' => Auth::id(),
                    'm_gudang_created_at' => Carbon::now(),
                );
                if (empty($validate)) {
                    DB::table('m_gudang')->insert($data);
                    $masterbb = DB::table('m_produk')
                        ->select('m_produk_id','m_produk_produksi_m_satuan_id','m_produk_utama_m_satuan_id')
                        ->whereNotIn('m_produk_m_klasifikasi_produk_id', [4])->get();
                    $gudang_id = DB::table('m_gudang')->max('m_gudang_id');
                    foreach ($masterbb as $key) {
                        $satuan_id = ($request->m_gudang_nama == 'gudang produksi waroeng') ? 
                        $key->m_produk_produksi_m_satuan_id : $key->m_produk_utama_m_satuan_id;
                        $satuan_kode = DB::table('m_satuan')->where('m_satuan_id',$satuan_id)->first()->m_satuan_kode;
                        $data_bb = array(
                            'm_stok_m_produk_id' => $key->m_produk_id,
                            'm_stok_gudang_id' => $gudang_id,
                            'm_stok_satuan_id' => $satuan_id,
                            'm_stok_satuan' => $satuan_kode,
                            'm_stok_awal' => 0,
                            'm_stok_created_by' => Auth::id(),
                            'm_stok_created_at' => Carbon::now(),
                        );
                        DB::table('m_stok')->insert($data_bb);
                    }
                    return response(['messages' => 'Berhasil Tambah Gudang !', 'type' => 'success']);
                } else {
                    return response(['messages' => 'Gagal Tambah Gudang Sudah Ada!', 'type' => 'danger']);
                }
                DB::table('m_gudang')->insert($data);
            } elseif ($request->action == 'edit') {
                $validate = DB::table('m_gudang')
                    ->where('m_gudang_m_w_id', $request->m_gudang_m_w_id)
                    ->where('m_gudang_nama', strtolower($request->m_gudang_nama))->first();
                $data = array(
                    'm_gudang_m_w_id' => $request->m_gudang_m_w_id,
                    'm_gudang_nama' => strtolower($request->m_gudang_nama),
                    'm_gudang_updated_by' => Auth::id(),
                    'm_gudang_updated_at' => Carbon::now(),
                );
                if ($validate == null) {
                    DB::table('m_gudang')->where('m_gudang_id', $request->m_gudang_id)
                        ->update($data);
                    return response(['messages' => 'Berhasil Update Gudang !', 'type' => 'success']);
                } else {
                    return response(['messages' => 'Gagal Update Gudang Sudah Ada!', 'type' => 'danger']);
                }
            } else {
                $softdelete = array('m_gudang_deleted_at' => Carbon::now());
                DB::table('m_gudang')
                    ->where('m_gudang_id', $request->m_gudang_id)
                    ->update($softdelete);
            }
            return response()->json($request);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = DB::table('m_gudang')->where('m_gudang_id', $id)->first();
        return response()->json($data);
    }

    public function gudang_out()
    {
        $data = new \stdClass();
        $get_max_id = DB::table('rekap_tf_gudang')->orderBy('rekap_tf_gudang_id','desc')->first();
        $user = Auth::id();
        $w_id = Auth::user()->waroeng_id;
        $waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$w_id)->first();
        $data->code = (empty($get_max_id->rekap_tf_gudang_id)) ? $urut = "600001". $user : $urut = substr($get_max_id->rekap_tf_gudang_code,0,-1)+'1'. $user; 
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->select('m_gudang_id','m_gudang_nama')
        ->where('m_gudang_m_w_id',$w_id)->get();
        return view('inventori::form_keluar_g', compact('data','waroeng_nama'));
    }
    
    function gudang_out_save(Request $request)
    {
        $tf_nota = array(
            'rekap_tf_gudang_code' => $request->rekap_tf_code,
            'rekap_tf_gudang_asal_id' => $request->rekap_tf_gudang_asal_id,
            'rekap_tf_gudang_tujuan_id' => $request->rekap_tf_gudang_tujuan_id,
            'rekap_tf_gudang_tgl_kirim' => Carbon::now(),
            'rekap_tf_gudang_ongkir' => $ongkir = (empty($request->rekap_tf_gudang_ongkir)) ? 0 : $request->rekap_tf_gudang_ongkir ,
            'rekap_tf_gudang_grand_tot' => $request->rekap_tf_gudang_grand_tot,
            'rekap_tf_gudang_created_by' => Auth::id(),
            'rekap_tf_gudang_created_at' => Carbon::now() 
        );
        DB::table('rekap_tf_gudang')->insert($tf_nota);
        foreach ($request->rekap_tf_g_detail_m_produk_id as $key => $value) {
            $satuan_kirim = DB::table('m_stok')
            ->where('m_stok_gudang_id',$request->rekap_tf_gudang_tujuan_id)
            ->where('m_stok_m_produk_id',$request->rekap_tf_g_detail_m_produk_id[$key])
            ->select('m_stok_satuan','m_stok_satuan_id')
            ->first();
            $satuan_asal = DB::table('m_stok')
            ->where('m_stok_gudang_id',$request->rekap_tf_gudang_asal_id)
            ->where('m_stok_m_produk_id',$request->rekap_tf_g_detail_m_produk_id[$key])
            ->first();
            $produk = DB::table('m_produk')
            ->where('m_produk_id',$request->rekap_tf_g_detail_m_produk_id[$key])
            ->select('m_produk_code','m_produk_nama')
            ->first();
            $tf_detail = array(
                'rekap_tf_g_detail_code' => $request->rekap_tf_code,
                'rekap_tf_g_detail_m_produk_code' => $produk->m_produk_code,
                'rekap_tf_g_detail_m_produk_id' => $request->rekap_tf_g_detail_m_produk_id[$key],
                'rekap_tf_g_detail_m_produk_nama' => $produk->m_produk_nama,
                'rekap_tf_g_detail_qty_kirim' => $request->rekap_tf_g_detail_qty_kirim[$key],
                'rekap_tf_g_detail_hpp' => $request->rekap_tf_g_detail_hpp[$key],
                'rekap_tf_g_detail_sub_total' => $request->rekap_tf_g_detail_sub_total[$key],
                'rekap_tf_g_detail_satuan_kirim' => $satuan_kirim->m_stok_satuan,
                'rekap_tf_g_detail_satuan_terima' => $satuan_asal->m_stok_satuan,
                'rekap_tf_g_detail_created_by' => Auth::id(),
                'rekap_tf_g_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_tf_gudang_detail')->insert($tf_detail);
            $mutasi_detail = array(
                'm_stok_detail_m_produk_id' => $request->rekap_tf_g_detail_m_produk_id[$key],
                'm_stok_detail_tgl'=> Carbon::now(),
                'm_stok_detail_m_produk_nama' => $produk->m_produk_nama,
                'm_stok_detail_satuan_id' => $satuan_kirim->m_stok_satuan_id,
                'm_stok_detail_satuan' => $satuan_kirim->m_stok_satuan,
                'm_stok_detail_keluar' => $request->rekap_tf_g_detail_qty_kirim[$key],
                'm_stok_detail_saldo' => $satuan_asal->m_stok_saldo - $request->rekap_tf_g_detail_qty_kirim[$key],
                'm_stok_detail_hpp' => $satuan_asal->m_stok_hpp,
                'm_stok_detail_catatan' => 'Transfer'.$request->rekap_tf_code,
                'm_stok_detail_gudang_id' => $request->rekap_tf_gudang_asal_id,
                'm_stok_detail_created_by' => Auth::id(),
                'm_stok_detail_created_at' => Carbon::now()
            );
            DB::table('m_stok_detail')->insert($mutasi_detail);
            $m_stok = array(
                'm_stok_keluar' => $request->rekap_tf_g_detail_qty_kirim[$key],
                'm_stok_saldo' => $satuan_asal->m_stok_saldo - $request->rekap_tf_g_detail_qty_kirim[$key]
            );
            DB::table('m_stok')->update($m_stok);
        }
        return redirect()->route('m_gudang_out.index')->with(['sukses' => 'Berhasil Transfer']);
    }
    public function gudang_terima()
    {
        $waroeng_id = Auth::user()->waroeng_id;
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
        return view('inventori::form_terima_g',compact('data'));
    }
    public function gudang_list_tf(Request $request)
    {
        $list_tf = DB::table('rekap_tf_gudang')
                ->where('rekap_tf_gudang_tujuan_id',$request)
                ->leftjoin('m_gudang','m_gudang_id','rekap_tf_gudang_tujuan_id')
                ->leftjoin('m_w','m_gudang_m_w_id','m_w_id')
                ->get();
        $no = 0;
        foreach ($list_tf as $key ) {
            $data = array();
                $no++;
                $row[] = $no;
                $row[] = $key->rekap_tf_gudang_code;
                $row[] = $key->rekap_tf_gudang_tgl_kirim;
                $row[] = $key->m_w_nama;
                $data[] = $row;

            $output = array("data" => $data);
            return response()->json($output);            
        }
    }
}
