<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MJenisNotaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_jenis_nota')
            ->selectRaw('Count(m_menu_harga_id) as total , m_jenis_nota.*, m_w_nama, m_t_t_name')
            ->leftjoin('m_w', 'm_jenis_nota_id', 'm_w_id')
            ->leftjoin('m_menu_harga', 'm_jenis_nota_id', 'm_jenis_nota_id')
            ->leftJoin('m_transaksi_tipe', 'm_jenis_nota_id', 'm_t_t_id')
            ->groupBy('m_jenis_nota_id', 'm_w_id', 'm_t_t_id')
            ->whereNull('m_jenis_nota_deleted_at')->get();
        return view('master::jenis_nota', compact('data'));
    }

    public function store(Request $request)
    {
        // nothing to validate data !
        try {
            $id_nota = $request->m_jenis_nota_sumber_id;
            DB::table('m_jenis_nota')->insert([
                'm_jenis_nota_m_w_id' => $request->m_jenis_nota_m_w_id,
                'm_jenis_nota_m_t_t_id' => $request->m_jenis_nota_m_t_t_id,
                'm_jenis_nota_created_by' => Auth::user()->id
            ]);
            $idbaru = DB::table('m_jenis_nota')->max('m_jenis_nota_id');
            if (isset($id_nota)) {
                $harga = DB::table('m_menu_harga')->where('m_menu_harga_m_jenis_nota_id', $id_nota)->get();
                foreach ($harga as $key => $val) {
                    DB::table('m_menu_harga')->insert([
                        'm_menu_harga_m_jenis_nota_id' => $idbaru,
                        'm_menu_harga_m_menu_id' => $val->m_menu_harga_m_menu_id,
                        'm_menu_harga_nominal' => $val->m_menu_harga_nominal,
                        'm_menu_harga_status' => '1',
                        'm_menu_harga_created_by' => Auth::user()->id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json('Error : ' . $e, 500);
        }
        return response()->json(['data' => 'success', 'response' => 200]);
    }
}
