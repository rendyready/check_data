<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class PecahGabungController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $gudang_default = DB::table('m_gudang')->select('m_gudang_id')
            ->where('m_gudang_m_w_id', $waroeng_id)->where('m_gudang_nama', 'gudang utama waroeng')->first()->m_gudang_id;
        $gudang_id = (empty($request->gudang_id)) ? $gudang_default : $request->gudang_id;
        $user = Auth::id();
        $data = new \stdClass();
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $waroeng_id)
            ->whereNotIn('m_gudang_nama', ['gudang produksi waroeng'])->get();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->nama_waroeng = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->satuan = DB::table('m_satuan')->get();
        $data->code = (empty($get_max_id->rekap_beli_id)) ? $urut = "8000001" . $user : $urut = substr($get_max_id->rekap_beli_code, 0, -1)+'1' . $user;
        return view('inventori::form_pcb', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        foreach ($request->rekap_pcb_brg_hasil_code as $key => $value) {
            $hpp_perbrg_asal = ($request->rekap_pcb_brg_asal_hppisi[$key]*$request->rekap_pcb_brg_asal_qty[$key]);
            $hpp_hasil = ($hpp_perbrg_asal/$request->rekap_pcb_brg_hasil_qty[$key]);
            $data = array(
                'rekap_pcb_code' => $request->rekap_pcb_code,
                'rekap_pcb_tgl' => Carbon::now(),
                'rekap_pcb_gudang_asal_code' => $request->rekap_pcb_gudang_asal_code,
                'rekap_pcb_waroeng' => $request->nama_waroeng,
                'rekap_pcb_aksi'=> $request->rekap_pcb_aksi,
                'rekap_pcb_brg_asal_code' => $request->rekap_pcb_brg_asal_code[$key],
                'rekap_pcb_brg_asal_nama' => $request->rekap_pcb_brg_asal_nama[$key],
                'rekap_pcb_brg_asal_satuan' => $request->rekap_pcb_brg_asal_satuan[$key],
                'rekap_pcb_brg_asal_isi' => $request->rekap_pcb_brg_asal_isi[$key],
                'rekap_pcb_brg_asal_qty' => $request->rekap_pcb_brg_asal_qty[$key],
                'rekap_pcb_brg_asal_hppisi' => $hpp_perbrg_asal,
                'rekap_pcb_brg_hasil_code' => $request->rekap_pcb_brg_hasil_code[$key],
                'rekap_pcb_brg_hasil_nama' => $request->rekap_pcb_brg_hasil_nama[$key],
                'rekap_pcb_brg_hasil_satuan' => $request->rekap_pcb_brg_hasil_satuan[$key],
                'rekap_pcb_brg_hasil_isi' => $request->rekap_pcb_brg_hasil_isi[$key],
                'rekap_pcb_brg_hasil_qty' => $request->rekap_pcb_brg_hasil_qty[$key],
                'rekap_pcb_brg_hasil_hpp' => $hpp_hasil,
                'rekap_pcb_created_by' => Auth::id(),
                'rekap_pcb_created_by_name' => $request->rekap_pcb_created_by_name,
            );
        }

    }

}
