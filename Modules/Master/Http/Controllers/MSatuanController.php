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
        $m_satuan_kode = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_satuan_kode)));
        $rules = [
            'm_satuan_kode' => 'required|unique:m_satuan|max:255',
        ];
        $data_validate = array(
            'm_satuan_kode' =>  $m_satuan_kode,
        );
        $validator = Validator::make($data_validate, $rules, $messages = [
            'm_satuan_kode.required' => 'Satuan Belum Terisi',
            'm_satuan_kode.unique' => 'Satuan Telah Ada !',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->messages()->all(),'type'=>'danger']);
        } else {
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_satuan_id' => $this->getMasterId('m_satuan'),
                        'm_satuan_kode'=>   $m_satuan_kode,
                        'm_satuan_keterangan'    =>    $request->m_satuan_keterangan,
                        'm_satuan_created_by' => Auth::user()->users_id,
                        'm_satuan_created_at' => Carbon::now(),
                    );
                    DB::table('m_satuan')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_satuan_kode' => $request->m_satuan_kode,
                        'm_satuan_keterangan' => $request->m_satuan_keterangan,
                        'm_satuan_status_sync' => 'send',
                        'm_satuan_updated_by' => Auth::user()->users_id,
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
                return response()->json(['error'=>['Berhasil'],'type'=>'success']);
            }
        }
    }
    public function satuan_kode_produk($id)
    {
        $satuan = DB::table('m_produk')->join('m_satuan','m_satuan_id','m_produk_utama_m_satuan_id')
        ->where('m_produk_code',$id)->select('m_satuan_kode')->first();
        return response()->json($satuan);
    }
}
