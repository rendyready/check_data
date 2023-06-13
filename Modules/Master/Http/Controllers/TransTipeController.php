<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

class TransTipeController extends Controller
{
    public function index()
    {
        $data = DB::table('m_transaksi_tipe')->whereNull('m_t_t_deleted_at')->get();
        return view('master::transaksi_tipe', compact('data'));
    }
    public function action(Request $request)
    {   $name = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_t_t_name)));
        $rules = [
            'm_t_t_name' => 'required|unique:m_transaksi_tipe|max:255',
            'm_t_t_profit_price' => 'required',
            'm_t_t_profit_in' => 'required',
            'm_t_t_profit_out' => 'required',
            'm_t_t_group' => 'required',
        ];
        $data_validate = array(
            'm_t_t_name' =>  $name,
            'm_t_t_profit_price' => $request->m_t_t_profit_price,
            'm_t_t_profit_in' => $request->m_t_t_profit_in,
            'm_t_t_profit_out' => $request->m_t_t_profit_out,
            'm_t_t_group' => $request->m_t_t_group,
        );
        $validator = Validator::make($data_validate, $rules, $messages = [
            'm_t_t_name.required' => 'Nama Belum Terisi',
            'm_t_t_name.unique' => 'Nama Duplikat',
            'm_t_t_profit_price.required' => 'Profit Price Belum Terisi',
            'm_t_t_profit_in.required' => 'Profit In Belum Terisi',
            'm_t_t_profit_out.required' => 'Profit Out Belum Terisi',
            'm_t_t_group.required' => 'Kelompok Belum Terisi'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->messages()->all(),'type'=>'danger']);
        } else {
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_t_t_id' => $this->getMasterId('m_transaksi_tipe'),
                        'm_t_t_name' => $name,
                        'm_t_t_profit_price' => $request->m_t_t_profit_price,
                        'm_t_t_profit_in' => $request->m_t_t_profit_in,
                        'm_t_t_profit_out' => $request->m_t_t_profit_out,
                        'm_t_t_group' => $request->m_t_t_group,
                        'm_t_t_created_by' => Auth::user()->users_id,
                        'm_t_t_created_at' => Carbon::now(),
                    );
                    DB::table('m_transaksi_tipe')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_t_t_name' => $request->m_t_t_name,
                        'm_t_t_profit_price' => $request->m_t_t_profit_price,
                        'm_t_t_status_sync' => 'send',
                        'm_t_t_updated_by' => Auth::user()->users_id,
                        'm_t_t_updated_at' => Carbon::now(),
                    );
                    DB::table('m_transaksi_tipe')->where('m_t_t_id', $request->m_t_t_id)
                        ->update($data);
                } else {
                    $softdelete = array('m_t_t_deleted_at' => Carbon::now(),'m_t_t_status_sync' => 'send');
                    DB::table('m_transaksi_tipe')
                        ->where('m_t_t_id', $request->m_t_t_id)
                        ->update($softdelete);
                }
                return response()->json(['error'=>['Berhasil'],'type'=>'success']);
            }
        }
    }
}
