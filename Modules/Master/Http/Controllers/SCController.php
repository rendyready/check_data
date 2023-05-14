<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;
use illuminate\Support\Facades\Validator;

class SCController extends Controller
{
    public function index()
    {
        $data = DB::table('m_sc')->whereNull('m_sc_deleted_at')->get();
        return view('master::sc', compact('data'));
    }
    public function action(Request $request)
    {

        $val = [
            'm_sc_value' => ['required']
        ];
        $value = [
            'm_sc_value' => Str::lower($request->m_sc_value)
        ];
        $validate = \Validator::make($request->all(), $val);
        if ($validate->fails()) {
            return response(['Message' => 'Data Duplicate !']);
        } else {
            if ($validate->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_sc_id' => $this->getMasterId('m_sc'),
                        'm_sc_value'    =>    $request->m_sc_value,
                        'm_sc_created_by' => Auth::id(),
                        'm_sc_created_at' => Carbon::now(),
                    );
                    DB::table('m_sc')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_sc_value'    =>    $request->m_sc_value,
                        'm_sc_status_sync' => 'send',
                        'm_sc_updated_by' => Auth::id(),
                        'm_sc_updated_at' => Carbon::now(),
                    );
                    DB::table('m_sc')->where('id', $request->id)
                        ->update($data);
                } else {
                    $softdelete = array('m_sc_jenis_deleted_at' => Carbon::now());
                    DB::table('m_sc')
                        ->where('id', $request->id)
                        ->update($softdelete);
                }
                return response(['Success' => $data]);
            }
        }
    }
}
