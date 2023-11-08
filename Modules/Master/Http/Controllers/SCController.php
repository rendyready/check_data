<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use illuminate\Support\Str;

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
            'm_sc_value' => ['required'],
        ];
        $value = [
            'm_sc_value' => Str::lower($request->m_sc_value),
        ];
        $validate = DB::table('m_sc')->where('m_sc_value', $request->m_sc_value)->first();
        if ($validate) {
            return response(['action' => 'add','type'=>'danger','message' => 'Data Duplicate !']);
        } else {
            if ($request->action == 'add') {
                $data = array(
                    // 'm_sc_id' => $this->getMasterId('m_sc'),
                    'm_sc_id' => '1',
                    'm_sc_value' => $request->m_sc_value,
                    'm_sc_created_by' => Auth::user()->users_id,
                    'm_sc_created_at' => Carbon::now(),
                );
                DB::table('m_sc')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_sc_value' => $request->m_sc_value,
                    'm_sc_status_sync' => 'send',
                    'm_sc_client_target' => DB::raw('DEFAULT'),
                    'm_sc_updated_by' => Auth::user()->users_id,
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
