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
    {
        $val = ['m_t_t_name' => ['required', 'unique:m_transaksi_tipe']];
        $value = ['m_t_t_name' => Str::lower($request->m_t_t_name)];
        $validate = \Validator::make($value, $val);
        if ($validate->fails()) {
            return response(['Message' => 'Data Dupliate']);
        } else {
            if ($validate->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_t_t_name' => Str::lower($request->m_t_t_name),
                        'm_t_t_profit_price' => $request->m_t_t_profit_price,
                        'm_t_t_profit_in' => $request->m_t_t_profit_in,
                        'm_t_t_profit_out' => $request->m_t_t_profit_out,
                        'm_t_t_group' => $request->m_t_t_group,
                        'm_t_t_created_by' => Auth::id(),
                        'm_t_t_created_at' => Carbon::now(),
                    );
                    DB::table('m_transaksi_tipe')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_t_t_name' => $request->m_t_t_name,
                        'm_t_t_profit_price' => $request->m_t_t_profit_price,
                        'm_menu_jenis_updated_by' => Auth::id(),
                        'm_menu_jenis_updated_at' => Carbon::now(),
                    );
                    DB::table('m_transaksi_tipe')->where('m_t_t_id', $request->m_t_t_id)
                        ->update($data);
                } else {
                    $softdelete = array('m_t_t_deleted_at' => Carbon::now());
                    DB::table('m_transaksi_tipe')
                        ->where('m_t_t_id', $request->m_t_t_id)
                        ->update($softdelete);
                }
                return response(['Congratulations' => $data]);
            }
        }
    }
}
