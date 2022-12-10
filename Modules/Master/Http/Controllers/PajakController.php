<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use illuminate\Support\Str;


class PajakController extends Controller
{
    public function index()
    {
        $data = DB::table('m_pajak')
            ->select('m_pajak_id', 'm_pajak_value')
            ->whereNull('m_pajak_deleted_at')->get();
        return view('master::pajak', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $upper = Str::upper($request->m_pajak_value);
            $check = DB::table('m_pajak')->whereRaw("UPPER(m_pajak_value)='{$upper}'")->first();
            if (!empty($check->m_pajak_value)) {
                $request->validate(
                    [
                        'm_pajak_value' => ['required', 'unique:m_pajak']
                    ]
                );
                if ($request->action == 'add') {

                    $data = array(
                        'm_pajak_value'    =>    $request->m_pajak_value,
                        'm_pajak_created_by' => Auth::id(),
                        'm_pajak_created_at' => Carbon::now(),
                    );
                    DB::table('m_pajak')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_pajak_value'    =>    $request->m_pajak_value,
                        'm_pajak_updated_by' => Auth::id(),
                        'm_pajak_updated_at' => Carbon::now(),
                    );
                    DB::table('m_pajak')->where('m_pajak_id', $request->id)
                        ->update($data);
                } else {
                    $softdelete = array('m_pajak_jenis_deleted_at' => Carbon::now());
                    DB::table('m_pajak')
                        ->where('m_pajak_id', $request->id)
                        ->update($softdelete);
                }
                return response()->json($request);
            }
        }
    }
}
