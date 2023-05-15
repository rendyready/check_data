<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
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
                $no_gd = $this->getMasterId('m_gudang');
                $waroeng = DB::table('m_w')->where('m_w_id', $request->m_gudang_m_w_id)->first();
                $code = str_pad($no_gd, 5, '6000', STR_PAD_LEFT);

                $data = array(
                    'm_gudang_id' => $no_gd,
                    'm_gudang_code' => $code,
                    'm_gudang_m_w_id' => $request->m_gudang_m_w_id,
                    'm_gudang_nama' => strtolower($request->m_gudang_nama),
                    'm_gudang_m_w_nama' => $waroeng->m_w_nama,
                    'm_gudang_created_by' => Auth::id(),
                    'm_gudang_created_at' => Carbon::now(),
                );
                if (empty($validate)) {
                    DB::table('m_gudang')->insert($data);
                    $gudang_nama = strtolower($request->m_gudang_nama);
                    if ($gudang_nama == 'gudang wbd waroeng' ) {
                        $masterbb = DB::table('m_produk')
                        ->where('m_produk_m_klasifikasi_produk_id',4)
                        ->where('m_produk_m_jenis_produk_id',11)
                        ->get();
                    } else {
                        $masterbb = DB::table('m_produk')
                        ->whereNotIn('m_produk_m_klasifikasi_produk_id', [4])->get();
                    }
                    $gudang = DB::table('m_gudang')->orderBy('m_gudang_id', 'desc')->first();
                    foreach ($masterbb as $key) {
                        $satuan_id = ($gudang_nama == 'gudang produksi waroeng') ?
                        $key->m_produk_isi_m_satuan_id : $key->m_produk_utama_m_satuan_id;
                        $satuan_kode = DB::table('m_satuan')->where('m_satuan_id', $satuan_id)->first()->m_satuan_kode;
                        $data_bb = array(
                            'm_stok_id' => $this->getMasterId('m_stok'),
                            'm_stok_m_produk_code' => $key->m_produk_code,
                            'm_stok_produk_nama' => $key->m_produk_nama,
                            'm_stok_gudang_code' => $gudang->m_gudang_code,
                            'm_stok_waroeng' => $waroeng->m_w_nama,
                            'm_stok_satuan_id' => $satuan_id,
                            'm_stok_satuan' => $satuan_kode,
                            'm_stok_m_klasifikasi_produk_id' => $key->m_produk_m_klasifikasi_produk_id,
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
                    'm_gudang_status_sync' => 'edit',
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
        $waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $w_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->select('m_gudang_code', 'm_gudang_nama')
            ->where('m_gudang_m_w_id', $w_id)
            ->whereNotIn('m_gudang_nama', ['gudang wbd waroeng'])
            ->get();
        return view('inventori::form_keluar_g', compact('data', 'waroeng_nama'));
    }

    public function gudang_out_save(Request $request)
    {
        foreach ($request->rekap_tf_gudang_m_produk_id as $key => $value) {
            $qty_kirim = convertfloat($request->rekap_tf_gudang_qty_kirim[$key]);
            $satuan_kirim = $this->get_last_stok($request->rekap_tf_gudang_tujuan_code, $request->rekap_tf_gudang_m_produk_id[$key]);
            $satuan_asal = $this->get_last_stok($request->rekap_tf_gudang_asal_code, $request->rekap_tf_gudang_m_produk_id[$key]);
            $rekap_tf = array(
                'rekap_tf_gudang_id' => $this->getMasterId('rekap_tf_gudang'),
                'rekap_tf_gudang_code' => $request->rekap_tf_gudang_code,
                'rekap_tf_gudang_asal_code' => $request->rekap_tf_gudang_asal_code,
                'rekap_tf_gudang_tujuan_code' => $request->rekap_tf_gudang_tujuan_code,
                'rekap_tf_gudang_tgl_keluar' => Carbon::now(),
                'rekap_tf_gudang_m_produk_code' => $request->rekap_tf_gudang_m_produk_id[$key],
                'rekap_tf_gudang_m_produk_nama' => $satuan_kirim->m_stok_produk_nama,
                'rekap_tf_gudang_qty_keluar' => $qty_kirim,
                'rekap_tf_gudang_hpp' => convertfloat($request->rekap_tf_gudang_hpp[$key]),
                'rekap_tf_gudang_sub_total' => convertfloat($request->rekap_tf_gudang_sub_total[$key]),
                'rekap_tf_gudang_satuan_keluar' => $satuan_asal->m_stok_satuan,
                'rekap_tf_gudang_satuan_terima' =>  $satuan_kirim->m_stok_satuan,
                'rekap_tf_gudang_m_w_id' => Auth::user()->waroeng_id,
                'rekap_tf_gudang_created_by' => Auth::id(),
                'rekap_tf_gudang_created_at' => Carbon::now(),
            );
            DB::table('rekap_tf_gudang')->insert($rekap_tf);

            $m_g_tj = DB::table('m_gudang')->where('m_gudang_code', $request->rekap_tf_gudang_tujuan_code)->first();
            $mutasi_detail = array(
                'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
                'm_stok_detail_code' => $this->getNextId('m_stok_detail', Auth::user()->waroeng_id),
                'm_stok_detail_m_produk_code' => $request->rekap_tf_gudang_m_produk_id[$key],
                'm_stok_detail_tgl' => Carbon::now(),
                'm_stok_detail_m_produk_nama' => $satuan_asal->m_stok_produk_nama,
                'm_stok_detail_satuan_id' => $satuan_asal->m_stok_satuan_id,
                'm_stok_detail_satuan' => $satuan_asal->m_stok_satuan,
                'm_stok_detail_keluar' => $qty_kirim,
                'm_stok_detail_saldo' => $satuan_asal->m_stok_saldo - $qty_kirim,
                'm_stok_detail_hpp' => $satuan_asal->m_stok_hpp,
                'm_stok_detail_catatan' => 'keluar ' . $m_g_tj->m_gudang_nama . ' ' . $request->rekap_tf_gudang_code,
                'm_stok_detail_gudang_code' => $request->rekap_tf_gudang_asal_code,
                'm_stok_detail_created_by' => Auth::id(),
                'm_stok_detail_created_at' => Carbon::now(),
            );
            DB::table('m_stok_detail')->insert($mutasi_detail);
            $m_stok = array(
                'm_stok_keluar' => $satuan_asal->m_stok_keluar + $qty_kirim,
                'm_stok_saldo' => $satuan_asal->m_stok_saldo - $qty_kirim,
            );
            DB::table('m_stok')
                ->where('m_stok_gudang_code', $request->rekap_tf_gudang_asal_code)
                ->where('m_stok_m_produk_code', $request->rekap_tf_gudang_m_produk_id[$key])
                ->update($m_stok);
        }
    }
    public function gudang_out_hist($id)
    {
        $data_histori = DB::table('rekap_tf_gudang')
        ->select('rekap_tf_gudang_code','rekap_tf_gudang_tgl_keluar',
        'name','m_gudang_nama','rekap_tf_gudang_qty_keluar','rekap_tf_gudang_satuan_keluar')
        ->join('users','users_id','rekap_tf_gudang_created_by')
        ->join('m_gudang','m_gudang_code','rekap_tf_gudang_tujuan_code')
        ->where('rekap_tf_gudang_asal_code',$id)
        ->whereDate('rekap_tf_gudang_tgl_keluar',Carbon::now())
        ->orderBy('rekap_tf_gudang_tgl_keluar','desc')
        ->get();
        $data = array();
        $no = 1;
        foreach ($data_histori as $key) {
            $row = array();
            $row[] = tgl_waktuid($key->rekap_tf_gudang_tgl_keluar);
            $row[] = $key->rekap_tf_gudang_code;
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = num_format($key->rekap_tf_gudang_qty_keluar);
            $row[] = $key->rekap_tf_gudang_satuan_keluar;
            $row[] = ucwords($key->name);

            $data[] = $row;
            $no++;
        }
        $output = array("data" => $data);
        return response()->json($output);

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
            ->whereNotIn('m_gudang_nama', ['gudang wbd waroeng'])
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
            ->leftjoin('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
            ->leftjoin('m_w', 'rekap_tf_gudang_m_w_id', 'm_w_id')
            ->leftjoin('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->orderBy('rekap_tf_gudang_id', 'desc')
            ->whereNull('rekap_tf_gudang_qty_terima')
            ->get();
        $data = array();
        foreach ($list_tf as $key) {
            $row = array();
            $row[] = tgl_waktuid($key->rekap_tf_gudang_tgl_keluar).'<input type="hidden" class="form-control hide form-control-sm" name="rekap_tf_gudang_id[]"  value="' . $key->rekap_tf_gudang_id . '" >';
            $row[] = $key->name. '<input type="hidden" class="form-control hide form-control-sm" name="rekap_tf_gudang_m_produk_code[]" value="' . $key->rekap_tf_gudang_m_produk_code . '" >';
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = $key->rekap_tf_gudang_m_produk_nama;
            $row[] = num_format($key->rekap_tf_gudang_qty_keluar);
            $row[] = $key->rekap_tf_gudang_satuan_keluar;
            $row[] = '<input type="text" class="form-control number form-control-sm" name="rekap_tf_gudang_qty_terima[]">';
            $row[] = $key->rekap_tf_gudang_satuan_terima;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);

    }
    public function gudang_terima_hist(Request $request)
    {
        $list_tf = DB::table('rekap_tf_gudang')
            ->where('rekap_tf_gudang_tujuan_code', $request->gudang_id)
            ->leftjoin('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
            ->leftjoin('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->orderBy('rekap_tf_gudang_id', 'desc')
            ->whereDate('rekap_tf_gudang_tgl_terima',Carbon::now())
            ->whereNotNull('rekap_tf_gudang_qty_terima')
            ->get();
        $data = array();
        foreach ($list_tf as $key) {
            $row = array();
            $row[] = tgl_waktuid($key->rekap_tf_gudang_tgl_keluar);
            $row[] = $key->name;
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = $key->rekap_tf_gudang_m_produk_nama;
            $row[] = num_format($key->rekap_tf_gudang_qty_keluar);
            $row[] = $key->rekap_tf_gudang_satuan_keluar;
            $row[] = num_format($key->rekap_tf_gudang_qty_terima);
            $row[] = $key->rekap_tf_gudang_satuan_terima;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function gudang_terima_simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        foreach ($request->rekap_tf_gudang_id as $key => $value) {
            $data_tf = DB::table('rekap_tf_gudang')->where('rekap_tf_gudang_id',$request->rekap_tf_gudang_id[$key])->first();
            $save_terima = DB::table('rekap_tf_gudang')
                ->where('rekap_tf_gudang_id', $request->rekap_tf_gudang_id[$key])
                ->update(['rekap_tf_gudang_qty_terima' => $request->rekap_tf_gudang_qty_terima[$key],
                    'rekap_tf_gudang_tgl_terima' => Carbon::now()]);
            $get_stok = $this->get_last_stok($request->rekap_tf_gudang_tujuan_code, $request->rekap_tf_gudang_m_produk_code[$key]);
            if (!empty($request->rekap_tf_gudang_qty_terima[$key])) {
                $stok_detail = array(
                    'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
                    'm_stok_detail_code' => $this->getNextId('m_stok_detail', $waroeng_id),
                    'm_stok_detail_m_produk_code' => $request->rekap_tf_gudang_m_produk_code[$key],
                    'm_stok_detail_tgl' => Carbon::now(),
                    'm_stok_detail_m_produk_nama' => $get_stok->m_stok_produk_nama,
                    'm_stok_detail_satuan_id' => $get_stok->m_stok_satuan_id,
                    'm_stok_detail_satuan' => $get_stok->m_stok_satuan,
                    'm_stok_detail_masuk' => $request->rekap_tf_gudang_qty_terima[$key],
                    'm_stok_detail_saldo' => $get_stok->m_stok_saldo + $request->rekap_tf_gudang_qty_terima[$key],
                    'm_stok_detail_hpp' => $data_tf->rekap_tf_gudang_hpp,
                    'm_stok_detail_catatan' => 'terima tf '.$data_tf->rekap_tf_gudang_code,
                    'm_stok_detail_gudang_code' => $request->rekap_tf_gudang_tujuan_code,
                    'm_stok_detail_created_by' => Auth::id(),
                    'm_stok_detail_created_at' => Carbon::now(),
                );
                DB::table('m_stok_detail')->insert($stok_detail);

                $data2 = array('m_stok_hpp' => $data_tf->rekap_tf_gudang_hpp,
                    'm_stok_masuk' => $get_stok->m_stok_masuk + $request->rekap_tf_gudang_qty_terima[$key],
                    'm_stok_saldo' => $get_stok->m_stok_saldo + $request->rekap_tf_gudang_qty_terima[$key],
                );
                DB::table('m_stok')->where('m_stok_gudang_code', $request->rekap_tf_gudang_tujuan_code)
                    ->where('m_stok_m_produk_code', $request->rekap_tf_gudang_m_produk_code[$key])
                    ->update($data2);
            }
        }

    }
    // Terima dari Gudang - End
    public function get_code()
    {
        $code = $this->getNextId('rekap_tf_gudang',Auth::user()->waroeng_id);
        return response()->json($code);
    }

}
