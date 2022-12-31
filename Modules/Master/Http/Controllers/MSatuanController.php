<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;


class MSatuanController extends Controller
{
    public function index()
    {
        $data = DB::table('m_satuan')->whereNull('m_satuan_deleted_at')->get();
        return view('master::m_satuan', compact('data'));
    }
    public function action(Request $request)
    {
        $raw = [
            'm_satuan_kode' => Str::lower($request->m_satuan_kode),

        ];
        $value = [
            'm_satuan_kode' => ['required', 'unique:m_satuan', 'max:225'],

        ];
        $validate = \Validator::make($raw, $value);
        if ($validate->fails()) {
            return response()
                ->json(['Messages' => 'Data Duplicate !']);
        } else {
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_satuan_kode'    =>   Str::lower($request->m_satuan_kode),
                        'm_satuan_keterangan'    =>    $request->m_satuan_keterangan,
                        'm_satuan_created_by' => Auth::id(),
                        'm_satuan_created_at' => Carbon::now(),
                    );
                    DB::table('m_satuan')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_satuan_kode'    =>    $request->m_satuan_kode,
                        'm_satuan_keterangan'    =>    $request->m_satuan_keterangan,
                        'm_satuan_updated_by' => Auth::id(),
                        'm_satuan_updated_at' => Carbon::now(),
                    );
                    DB::table('m_satuan')->where('m_satuan_id', $request->id)
                        ->update($data);
                } else {
                    $softdelete = array('m_satuan_deleted_at' => Carbon::now());
                    DB::table('m_satuan')
                        ->where('m_satuan_id', $request->id)
                        ->update($softdelete);
                }
                return response(['Messages' => 'Congratulations !']);
            }
        }
    }
    public function satuan_kode_produk($id)
    {
        $satuan = DB::table('m_produk')->join('m_satuan','m_satuan_id','m_produk_m_satuan_id')
        ->where('m_produk_id',$id)->select('m_satuan_kode')->first();
        return $satuan;
    }
}
