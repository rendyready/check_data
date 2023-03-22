<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RphController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $rph = DB::table('rph')
            ->join('users', 'users_id', 'rph_created_by')
            ->where('rph_m_w_code', sprintf("%03d", $waroeng_id))
            ->where('rph_created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('rph_created_at','desc')
            ->get();
        return view('inventori::form_input_rph', compact('rph', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->jenis = DB::table('m_jenis_produk')->get();
        $data->produk = DB::table('m_produk')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])->get();
        $data->num = 1;
        $data->n = 1;
        $data->s = 1;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->rph_code = $this->getNextId('rph', $waroeng_id);
        return view('inventori::form_input_rph_detail', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $cek_rph_valid = DB::table('rph')
        ->where('rph_m_w_code',sprintf("%03d", $waroeng_id))
        ->where('rph_tgl',$request->rph_tgl)
        ->first();
        if (empty($cek_rph_valid)) {
            
            $rph = array(
                'rph_code' => $request->rph_code,
                'rph_tgl' => $request->rph_tgl,
                'rph_m_w_code' => sprintf("%03d", $waroeng_id),
                'rph_m_w_nama' => strtolower($request->rph_m_w_nama),
                'rph_created_by' => Auth::user()->users_id,
                'rph_created_at' => Carbon::now(),
            );
            DB::table('rph')->insert($rph);
            foreach ($request->rph_detail_menu_m_produk_code as $key => $value) {
                if (!empty($request->rph_detail_menu_qty[$key])) {
                    $menu_nama = DB::table('m_produk')
                        ->where('m_produk_code', $request->rph_detail_menu_m_produk_code[$key])
                        ->select('m_produk_nama')
                        ->first();
                    $rph_menu = array(
                        'rph_detail_menu_id' => $this->getNextId('rph_detail_menu', $waroeng_id),
                        'rph_detail_menu_rph_code' => $request->rph_code,
                        'rph_detail_menu_m_produk_code' => $request->rph_detail_menu_m_produk_code[$key],
                        'rph_detail_menu_m_produk_nama' => $menu_nama->m_produk_nama,
                        'rph_detail_menu_qty' => $request->rph_detail_menu_qty[$key],
                        'rph_detail_menu_created_by' => Auth::user()->users_id,
                        'rph_detail_menu_created_at' => Carbon::now(),
                    );
                    DB::table('rph_detail_menu')->insert($rph_menu);
                }
            }
            return response()->json(['messages' => 'Berhasil Menyimpan RPH', 'type' => 'success']);
        } else {
            return response()->json(['messages' => 'RPH dengan tanggal tsb sudah ada silahkan lakukan edit', 'type' => 'danger']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->jenis = DB::table('m_jenis_produk')->get();
        $data->produk = DB::table('m_produk')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])->get();
        $data->num = 1;
        $data->n = 1;
        $data->s = 1;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->rph_code = $id;
        $data->rph_edit = DB::table('rph')
            ->join('rph_detail_menu', 'rph_detail_menu_rph_code', 'rph_code')
            ->where('rph_code', $id)->get();
        $data->rph_tgl = DB::table('rph')->where('rph_code', $id)->first()->rph_tgl;
        $data->aksi = 'edit';
        return view('inventori::form_input_rph_edit', compact('data'));
    }
    public function detail($id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->jenis = DB::table('m_jenis_produk')->get();
        $data->produk = DB::table('m_produk')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])->get();
        $data->num = 1;
        $data->n = 1;
        $data->s = 1;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->rph_code = $id;
        $data->rph_edit = DB::table('rph')
            ->join('rph_detail_menu', 'rph_detail_menu_rph_code', 'rph_code')
            ->where('rph_code', $id)->get();
        $data->rph_tgl = DB::table('rph')->where('rph_code', $id)->first()->rph_tgl;
        $data->aksi = 'detail';
        return view('inventori::form_input_rph_edit', compact('data'));
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        foreach ($request->rph_detail_menu_m_produk_code as $key => $value) {
            if (!empty($request->rph_detail_menu_qty[$key])) {
                $menu_nama = DB::table('m_produk')
                    ->where('m_produk_code', $request->rph_detail_menu_m_produk_code[$key])
                    ->select('m_produk_nama')
                    ->first();
                $rph_menu = array(
                    'rph_detail_menu_id' => $this->getNextId('rph_detail_menu', $waroeng_id),
                    'rph_detail_menu_rph_code' => $request->rph_code,
                    'rph_detail_menu_m_produk_code' => $request->rph_detail_menu_m_produk_code[$key],
                    'rph_detail_menu_m_produk_nama' => $menu_nama->m_produk_nama,
                    'rph_detail_menu_qty' => $request->rph_detail_menu_qty[$key],
                    'rph_detail_menu_created_by' => Auth::user()->users_id,
                    'rph_detail_menu_created_at' => Carbon::now(),
                );
                DB::table('rph_detail_menu')->updateOrInsert(
                    ['rph_detail_menu_rph_code' => $request->rph_code, 'rph_detail_menu_m_produk_code' => $request->rph_detail_menu_m_produk_code[$key]],
                    $rph_menu
                );
            }
        }
    }

}
