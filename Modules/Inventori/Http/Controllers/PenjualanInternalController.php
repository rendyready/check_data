<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class PenjualanInternalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $user = Auth::id();
        $waroeng_id = Auth::user()->waroeng_id;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id',$waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')
        ->where('m_gudang_m_w_id',Auth::user()->waroeng_id)
        ->whereNotIn('m_gudang_nama',['gudang produksi waroeng'])
        ->get(); 
        $data->code = $this->getNextId('rekap_beli',$waroeng_id);
        $data->waroeng = DB::table('m_w')->select('m_w_code','m_w_nama')->get(); 
        return view('inventori::form_penjualan_internal',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan()
    {
        return view('inventori::create');
    }
}
