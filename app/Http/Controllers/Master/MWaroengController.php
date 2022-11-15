<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MWaroengController extends Controller
{
    public function index()
    {
        return view('master.m_waroeng');
    }
    public function list()
    {
        $data = new \stdClass();
        $area = DB::table('m_area')->select('m_area_id','m_area_nama')->get();
        $jenisw = DB::table('m_w_jenis')->select('m_w_jenis_id','m_w_jenis_nama')->get();
        $modalt = DB::table('m_modal_tipe')->select('m_modal_tipe_id','m_modal_tipe_nama')->get();
        $data->area = array(); $data->jenisw = array(); $data->modalt = array();
        foreach ($area as $key => $v) {
            $data->area[$v->m_area_id]=$v->m_area_nama;}
        foreach ($jenisw as $key => $v) {
            $data->jenisw[$v->m_w_jenis_id]=$v->m_w_jenis_nama;}
        foreach ($modalt as $key => $v) {
            $data->modalt[$v->m_modal_tipe_id]=$v->m_modal_tipe_nama;}
        return response()->json($data);
    }
}
