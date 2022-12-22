<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;
use illuminate\Support\Facades\Validator;



class WJenisController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w_jenis')->whereNull('m_w_jenis_deleted_at')->get();
        return view('master::jenis_waroeng', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $val = ['m_w_jenis_nama' => ['required', 'unique:m_w_jenis']];
            $value = ['m_w_jenis_nama' => Str::lower($request->m_w_jenis_nama)];
            if ($request->action == 'add') {

                $validate = \Validator::make($value, $val);
                if ($validate->fails()) {
                    return response(['Messages' => 'Data Duplicate ! ']);
                } else {

                    $data = array(
                        'm_w_jenis_nama'    =>  Str::lower($request->m_w_jenis_nama),
                        'm_w_jenis_created_by' => Auth::id(),
                        'm_w_jenis_created_at' => Carbon::now(),
                    );
                    DB::table('m_w_jenis')->insert($data);
                }
                return response(['Messages' => 'Congratulations !']);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_w_jenis_nama'    =>    $request->m_w_jenis_nama,
                    'm_w_jenis_updated_by' => Auth::id(),
                    'm_w_jenis_updated_at' => Carbon::now(),
                );
                DB::table('m_w_jenis')->where('m_w_jenis_id', $request->m_w_jenis_id)
                    ->update($data);
                return response(['Messages' => 'Data Update !']);
            } else {
                $softdelete = array('m_w_jenis_deleted_at' => Carbon::now());
                DB::table('m_w_jenis')
                    ->where('m_w_jenis_id', $request->m_w_jenis_id)
                    ->update($softdelete);
                return response(['Messages' => 'Data Delete !']);
            }
            return response(['Success' => true]);
        }
    }
}
