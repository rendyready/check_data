<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MStokController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $gudang = DB::table('m_gudang')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->select('m_gudang_code', 'm_gudang_nama', 'm_w_nama')->get();
        $waroeng_id = Auth::user()->waroeng_id;
        $tgl_now = Carbon::now()->format('Y-m-d');
        return view('inventori::form_stok_awal', compact('gudang', 'tgl_now'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    function list($id) {
        $stok = DB::table('m_stok')
            ->where('m_stok_gudang_code', $id)
            ->orderByRaw('m_stok_updated_at is NULL')
            ->orderByDesc('m_stok_updated_at')
            ->get();
        $no = 0;
        $data = array();
        foreach ($stok as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = ucwords($value->m_stok_produk_nama);
            $row[] = $value->m_stok_awal;
            $row[] = $value->m_stok_hpp;
            $row[] = $value->m_stok_satuan;
            $row[] = $retVal = (empty($value->m_stok_updated_at)) ? tgl_waktuid($value->m_stok_created_at) : tgl_waktuid($value->m_stok_updated_at);
            $data[] = $row;
        }
        $output = array('data' => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $messages = ['required' => 'Gudang Wajib dipilih Dahulu !'];
        $validated = $request->validate([
            'm_stok_gudang_code' => 'required',
        ], $messages);
        foreach ($request->m_stok_m_produk_code as $key => $value) {
            $cek = DB::table('m_stok')->where('m_stok_gudang_code', $request->m_stok_gudang_code)
                ->where('m_stok_m_produk_code', $request->m_stok_m_produk_code[$key])->first();
            $hpp = $cek->m_stok_hpp;
            $saldo = $cek->m_stok_saldo;
            $hpp_new = (($hpp * $saldo) + (convertfloat($request->m_stok_awal[$key]) * convertfloat($request->m_stok_hpp[$key]))) / ($saldo + convertfloat($request->m_stok_awal[$key]));

            $data = array(
                'm_stok_awal' => convertfloat($request->m_stok_awal[$key]),
                'm_stok_hpp' => $hpp_new,
                'm_stok_saldo' => $saldo + convertfloat($request->m_stok_awal[$key]),
                'm_stok_updated_at' => Carbon::now(),
            );

            DB::table('m_stok')->where('m_stok_gudang_code', $request->m_stok_gudang_code)
                ->where('m_stok_m_produk_code', $request->m_stok_m_produk_code[$key])->update($data);

        }
        return response()->json(['message' => 'Sukses Menambah Stok Awal', 'type' => 'success']);

    }
    public function master_stok($id)
    {
        $data = DB::table('m_stok')->where('m_stok_gudang_code', $id)
            ->get();
        $list = array();
        foreach ($data as $key => $v) {
            $list[$v->m_stok_m_produk_code] = $v->m_stok_produk_nama;
        }
        return response()->json($list);
    }
    public function get_harga($id_g, $id_p)
    {
        $data = DB::table('m_stok')
            ->where('m_stok_gudang_code', $id_g)
            ->where('m_stok_m_produk_code', $id_p)
            ->first();
        return response()->json($data);
    }
    public function so_index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->where('m_gudang_m_w_id', $waroeng_id)->get();
        return view('inventori::form_input_so', compact('data'));
    }

    public function so_list($id)
    {
        $so = DB::table('rekap_so')
            ->join('users', 'users_id', 'rekap_so_created_by')
            ->where('rekap_so_detail_m_gudang_code', $id)
            ->orderBy('rekap_so_created_at', 'desc')
            ->get();
        return response()->json($so);
    }

    public function so_create($g_id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->stok = DB::table('m_stok')
            ->where('m_stok_gudang_code', $g_id)
            ->orderBy('m_stok_id','asc')
            ->get();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->so_code = $this->getNextId('rekap_so', $waroeng_id);
        $data->tgl_now = tgl_indo(Carbon::now());
        $data->gudang_nama = DB::table('m_gudang')->where('m_gudang_code',$g_id)->first()->m_gudang_nama;
        return view('inventori::form_input_so_detail',compact('data'));
    }
    public function so_simpan(Request $request)
    {
        return $request->all();
    }
}
