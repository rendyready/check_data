<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class SubJenisMController extends Controller
{
    public function index()
    {
        $data = DB::table('m_sub_menu_jenis as msj')
        ->leftjoin('m_menu_jenis as mmj', 'msj.m_sub_menu_jenis_m_menu_jenis_id', '=', 'mmj.id')
        ->select('msj.id','msj.m_sub_menu_jenis_nama','mmj.m_menu_jenis_nama')->get();
        return view('master.sub_jenis_menu',compact('data'));
    }
}
