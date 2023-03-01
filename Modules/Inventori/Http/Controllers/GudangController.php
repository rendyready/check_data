<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
    function list() {
        $no = 0;
        $gudang = DB::table('m_gudang')->get();
        $data = array();
        foreach ($gudang as $key) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $key->m_gudang_code;
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = $key->m_gudang_m_w_nama;
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
                $no_gd = $this->getlast('m_gudang','m_gudang_code');
                $waroeng = DB::table('m_w')->where('m_w_id',$request->m_gudang_m_w_id)->first();
                $code = str_pad($no_gd,5,'6000',STR_PAD_LEFT);

                $data = array(
                    'm_gudang_id' => $no_gd ,
                    'm_gudang_code' => $code,
                    'm_gudang_m_w_id' => $request->m_gudang_m_w_id,
                    'm_gudang_nama' => strtolower($request->m_gudang_nama),
                    'm_gudang_m_w_nama' => $waroeng->m_w_nama,
                    'm_gudang_created_by' => Auth::id(),
                    'm_gudang_created_at' => Carbon::now(),
                );
                if (empty($validate)) {
                    DB::table('m_gudang')->insert($data);
                    $masterbb = DB::table('m_produk')
                        ->whereNotIn('m_produk_m_klasifikasi_produk_id', [4])->get();
                    $gudang = DB::table('m_gudang')->orderBy('m_gudang_id','desc')->first();
                    foreach ($masterbb as $key) {
                        $satuan_id = ($request->m_gudang_nama == 'gudang produksi waroeng') ?
                        $key->m_produk_isi_m_satuan_id : $key->m_produk_utama_m_satuan_id;
                        $satuan_kode = DB::table('m_satuan')->where('m_satuan_id', $satuan_id)->first()->m_satuan_kode;
                        $data_bb = array(
                            'm_stok_id' => $this->getlast('m_stok','m_stok_id'),
                            'm_stok_m_produk_code' => $key->m_produk_code,
                            'm_stok_produk_nama' => $key->m_produk_nama,
                            'm_stok_gudang_code' => $gudang->m_gudang_code,
                            'm_stok_waroeng' =>  $waroeng->m_w_nama,
                            'm_stok_satuan_id' => $satuan_id,
                            'm_stok_satuan' => $satuan_kode,
                            'm_stok_awal' => 0,
                            'm_stok_isi' => $key->m_produk_qty_isi,
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

    // Keluar Gudang - Begin
    public function gudang_out()
    {
        $data = new \stdClass();
        $user = Auth::id();
        $w_id = Auth::user()->waroeng_id;
        $get_max_id = $this->getNextId('rekap_tf_gudang',$w_id);
        $waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $w_id)->first();
        $data->code = $get_max_id;
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->select('m_gudang_code', 'm_gudang_nama')
            ->where('m_gudang_m_w_id', $w_id)
            ->get();
        return view('inventori::form_keluar_g', compact('data', 'waroeng_nama'));
    }

    public function gudang_out_save(Request $request)
    {
        $tf_nota = array(
            'rekap_tf_gudang_id' => $this->getlast('rekap_tf_gudang','rekap_tf_gudang_id'),
            'rekap_tf_gudang_code' => $request->rekap_tf_g_detail_code,
            'rekap_tf_gudang_asal_code' => $request->rekap_tf_gudang_asal_code,
            'rekap_tf_gudang_tujuan_code' => $request->rekap_tf_gudang_tujuan_code,
            'rekap_tf_gudang_tgl_kirim' => Carbon::now(),
            'rekap_tf_gudang_grand_tot' => $request->rekap_tf_gudang_grand_tot,
            'rekap_tf_gudang_created_by' => Auth::id(),
            'rekap_tf_gudang_created_at' => Carbon::now(),
        );
        DB::table('rekap_tf_gudang')->insert($tf_nota);
        foreach ($request->rekap_tf_g_detail_m_produk_id as $key => $value) {
            $satuan_kirim = DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->rekap_tf_gudang_tujuan_code)
                ->where('m_stok_m_produk_code', $request->rekap_tf_g_detail_m_produk_id[$key])
                ->first();
            $satuan_asal = DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->rekap_tf_gudang_asal_code)
                ->where('m_stok_m_produk_code', $request->rekap_tf_g_detail_m_produk_id[$key])
                ->first();
            $tf_detail = array(
                'rekap_tf_g_detail_id' => $this->getlast('rekap_tf_gudang_detail','rekap_tf_g_detail_id'),
                'rekap_tf_g_detail_code' => $request->rekap_tf_g_detail_code,
                'rekap_tf_g_detail_m_produk_code' => $request->rekap_tf_g_detail_m_produk_id[$key],
                'rekap_tf_g_detail_m_produk_nama' => $satuan_kirim->m_stok_produk_nama,
                'rekap_tf_g_detail_qty_kirim' => $request->rekap_tf_g_detail_qty_kirim[$key],
                'rekap_tf_g_detail_hpp' => $request->rekap_tf_g_detail_hpp[$key],
                'rekap_tf_g_detail_sub_total' => $request->rekap_tf_g_detail_sub_total[$key],
                'rekap_tf_g_detail_satuan_kirim' => $satuan_kirim->m_stok_satuan,
                'rekap_tf_g_detail_satuan_terima' => $satuan_asal->m_stok_satuan,
                'rekap_tf_g_detail_created_by' => Auth::id(),
                'rekap_tf_g_detail_created_at' => Carbon::now(),
            );
            DB::table('rekap_tf_gudang_detail')->insert($tf_detail);
            $m_g_tj = DB::table('m_gudang')->where('m_gudang_code',$request->rekap_tf_gudang_tujuan_code)->first();
            $mutasi_detail = array(
                'm_stok_detail_id' => $this->getlast('m_stok_detail','m_stok_detail_id'),
                'm_stok_detail_m_produk_code' => $request->rekap_tf_g_detail_m_produk_id[$key],
                'm_stok_detail_tgl' => Carbon::now(),
                'm_stok_detail_m_produk_nama' => $satuan_kirim->m_stok_produk_nama,
                'm_stok_detail_satuan_id' => $satuan_kirim->m_stok_satuan_id,
                'm_stok_detail_satuan' => $satuan_kirim->m_stok_satuan,
                'm_stok_detail_keluar' => $request->rekap_tf_g_detail_qty_kirim[$key],
                'm_stok_detail_saldo' => $satuan_asal->m_stok_saldo - $request->rekap_tf_g_detail_qty_kirim[$key],
                'm_stok_detail_hpp' => $satuan_asal->m_stok_hpp,
                'm_stok_detail_catatan' => 'transfer ke '.$m_g_tj->m_gudang_nama.' '.$m_g_tj->m_gudang_m_w_nama ,
                'm_stok_detail_gudang_code' => $request->rekap_tf_gudang_asal_code,
                'm_stok_detail_created_by' => Auth::id(),
                'm_stok_detail_created_at' => Carbon::now(),
            );
            DB::table('m_stok_detail')->insert($mutasi_detail);
            $m_stok = array(
                'm_stok_keluar' => $request->rekap_tf_g_detail_qty_kirim[$key],
                'm_stok_saldo' => $satuan_asal->m_stok_saldo - $request->rekap_tf_g_detail_qty_kirim[$key],
            );
            DB::table('m_stok')->update($m_stok);
        }
        return redirect()->route('m_gudang_out.index')->with(['sukses' => 'Berhasil Transfer']);
    }
    //Keluar Gudang - End

    // Terima dari Gudang - Begin
    public function gudang_terima()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $gudang_default = DB::table('m_gudang')->select('m_gudang_id')
            ->where('m_gudang_m_w_id', $waroeng_id)->where('m_gudang_nama', 'gudang utama waroeng')->first()->m_gudang_id;
        $gudang_id = (empty($request->gudang_id)) ? $gudang_default : $request->gudang_id;
        $data = new \stdClass();
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $waroeng_id)
            ->get();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        return view('inventori::form_terima_g', compact('data'));
    }

    public function gudang_list_tf(Request $request)
    {
        $list_tf = DB::table('rekap_tf_gudang')
            ->where('rekap_tf_gudang_tujuan_code', $request->gudang_id)
            ->leftjoin('m_gudang', 'm_gudang_id', 'rekap_tf_gudang_asal_code')
            ->leftjoin('m_w', 'm_gudang_m_w_id', 'm_w_id')
            ->orderBy('rekap_tf_gudang_id', 'desc')
            ->get();
        $no = 0;
        foreach ($list_tf as $key) {
            $data = array();
            $no++;
            $row[] = $no;
            $row[] = $key->rekap_tf_gudang_code;
            $row[] = tgl_waktuid($key->rekap_tf_gudang_tgl_kirim);
            $row[] = $key->m_w_nama;
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = $status = ($key->rekap_tf_gudang_tgl_terima == null) ? 'Belum CHT' : 'Sudah CHT';
            $row[] = $aksi = ($key->rekap_tf_gudang_tgl_terima == null) ? '<a id="buttonCHT" class="btn btn-sm buttonCHT btn-success" value="' . $key->rekap_tf_gudang_code . '" title="CHT"><i class="fa fa-pencil"></i></a>' : '<a id="buttonDetail" class="btn btn-sm buttonDetail btn-info" value="' . $key->rekap_tf_gudang_id . '" title="Detail"><i class="fa fa-eye"></i></a>';
            $data[] = $row;
            $output = array("data" => $data);
            return response()->json($output);
        }

    }
    public function gudang_terima_transfer($id)
    {
        $detail = DB::table('rekap_tf_gudang_detail')
            ->select('rekap_tf_g_detail_id','rekap_tf_g_detail_code','rekap_tf_g_detail_m_produk_id',
                     'rekap_tf_g_detail_m_produk_nama','rekap_tf_g_detail_qty_kirim','rekap_tf_g_detail_qty_terima',
                     'rekap_tf_g_detail_satuan_kirim','rekap_tf_g_detail_satuan_terima')
            ->where('rekap_tf_g_detail_code', $id)
            ->get();
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        $data->no_trans = $id;
        return view('inventori::form_cht_keluar_g', compact('data','detail','tgl_now'));
    }
    public function gudang_terima_simpan(Request $request)
    {
        foreach ($request->id as $key => $value) {
            $terima_save = DB::table('rekap_tf_gudang_detail')->where('rekap_tf_g_detail_id',$request->id[$key])
            ->update(['rekap_tf_g_detail_qty_terima' => $request->rekap_tf_g_detail_qty_terima[$key]]);
            $terima_nota_update = DB::table('rekap_tf_gudang')->where('rekap_tf_gudang_code',$request->rekap_tf_g_detail_code)
            ->update(['rekap_tf_gudang_tgl_terima'=>Carbon::now()]);
        }
        return redirect()->route('m_gudang.terima_tf');
        
    }
    // Terima dari Gudang - End

}
