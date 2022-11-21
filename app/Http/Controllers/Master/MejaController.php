<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MejaController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->no = 1;
        $data->meja = DB::table('config_meja')
        ->leftjoin('m_meja_jenis','config_meja_m_meja_jenis_id','m_meja_jenis_id')
        ->leftjoin('m_w','m_w_id','config_meja_m_w_id')
        ->whereNull('config_meja_deleted_at')->get();
        $data->jenis_meja = DB::table('m_meja_jenis')->get();
        $data->waroeng = DB::table('m_w')->get();
        return view('master.m_meja',compact('data'));
    }
    public function FunctionName(Type $var = null)
    {
        # code...
    }
}
