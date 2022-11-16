<?php

namespace App\Http\Controllers\Master;

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
        ->selectRaw('Count(m_menu_harga_id) as total , m_jenis_nota.*, m_w_nama ')
        ->leftjoin('m_w','m_jenis_nota_id','m_w_m_w_jenis_id')
        ->leftjoin('m_menu_harga', 'm_jenis_nota_id','m_menu_harga_m_jenis_nota_id')
        ->groupBy('m_jenis_nota_id', 'm_w_id')
        ->whereNull('m_jenis_nota_deleted_at')->get();
        return view('master.jenis_nota',compact('data'));
    }
}
