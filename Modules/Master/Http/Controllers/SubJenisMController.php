<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

class SubJenisMController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->sub = DB::table('m_sub_jenis_produk as msj')
            ->leftjoin('m_jenis_produk as mmj', 'msj.m_sub_jenis_produk_m_jenis_produk_id', '=', 'mmj.m_jenis_produk_id')
            ->select('msj.m_sub_jenis_produk_id', 'msj.m_sub_jenis_produk_nama', 'mmj.m_jenis_produk_nama')
            ->whereNull('msj.m_sub_jenis_produk_deleted_at')->get();

        return view('master::sub_jenis_menu', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $val = ['m_sub_jenis_produk_nama' => ['required', 'unique:m_sub_jenis_produk']];
                $value = ['m_sub_jenis_produk_nama' => Str::lower($request->m_sub_jenis_produk_nama)];
                $validate = \Validator::make($value, $val);
                if ($validate->fails()) {
                    return response(['Messages' => 'Data Duplicate !']);
                } else {
                    $data = array(
                        'm_sub_jenis_produk_id' => $this->getMasterId('m_sub_jenis_produk'),
                        'm_sub_jenis_produk_nama'    =>  Str::lower($request->m_sub_jenis_produk_nama),
                        'm_sub_jenis_produk_m_jenis_produk_id' => $request->m_jenis_produk_id,
                        'm_sub_jenis_produk_created_by' => Auth::id(),
                        'm_sub_jenis_produk_created_at' => Carbon::now(),
                    );
                    DB::table('m_sub_jenis_produk')->insert($data);
                    return response(['Messages' => 'Congratulations !']);
                }
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_sub_jenis_produk_nama'    =>    $request->m_sub_jenis_produk_nama,
                    'm_sub_jenis_produk_m_jenis_produk_id' => $request->m_sub_jenis_produk_m_jenis_produk_id,
                    'm_sub_jenis_produk_status_sync' => 'send',
                    'm_sub_jenis_produk_updated_by' => Auth::id(),
                    'm_sub_jenis_produk_updated_at' => Carbon::now(),
                );
                DB::table('m_sub_jenis_produk', 'm_jenis_produk')->where('m_sub_jenis_produk_m_jenis_produk_id', $request->id)
                    ->update($data);
                return response(['Messages' => 'Data Updated !']);
            } else {
                $softdelete = array('m_sub_jenis_produk_deleted_at' => Carbon::now(),'m_sub_jenis_produk_status_sync' => 'send');
                DB::table('m_sub_jenis_produk')
                    ->where('m_sub_jenis_produk_m_jenis_produk_id', $request->id)
                    ->update($softdelete);
                return response(['Messages' => 'Data Deleted !']);
            }
            return response(['Success' => true]);
        }
    }

    public function list()
    {
        $data = new \stdClass();
        $data1 = DB::table('m_jenis_produk')->select('m_jenis_produk_id', 'm_jenis_produk_nama')->get();
        $a = array();
        foreach ($data1 as $key => $value) {
            $a[$value->m_jenis_produk_id] = $value->m_jenis_produk_nama;
        }
        $data->m_jenis_menu = $a;
        return response()->json($data);
    }
}
