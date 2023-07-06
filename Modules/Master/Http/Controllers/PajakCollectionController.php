<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PajakCollectionController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w')->orderBy('m_w_id', 'asc')->get();
        return view('master::pajak_collection', compact('data'));
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'edit') {
                if (!empty($request->m_w_collect_status == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !', 'type' => 'danger']);
                } else {
                    $data = array(
                        'm_w_id' => $request->m_w_id,
                        'm_w_collect_status' => $request->m_w_collect_status,
                        'm_w_client_target' => DB::raw('DEFAULT'),
                        'm_w_updated_by' => Auth::user()->users_id,
                        'm_w_updated_at' => Carbon::now(),
                    );
                    DB::table('m_w')->where('m_w_id', $request->m_w_id)->update($data);
                    return response(['Messages' => 'Status Collect Update !', 'type' => 'success']);
                }
            }
        }
    }
}
