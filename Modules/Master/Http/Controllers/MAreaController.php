<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MArea;
use Carbon\Carbon;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MArea::select('m_area_id', 'm_area_nama', 'm_area_code')->whereNull('m_area_deleted_at')->orderBy('m_area_id', 'asc')->get();
        return view('master::area', compact('data'));
        return response($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $dataRaw = Str::upper($request->m_area_nama);
        $checkUpper =  DB::table('m_area')->whereRaw("UPPER(m_area_nama)='{$dataRaw}'")
            ->first();
        $newReq = new Request();
        $this->validate(
            $request,
            [
                'm_area_nama' => ['required', 'unique:m_area'],
                'm_area_code' => ['required', 'unique:m_area'],
            ]
        );
        if (!empty($request->m_area_nama)) {
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_area_nama'    =>    $request->m_area_nama,
                        'm_area_code'    =>    $request->m_area_code,
                        'm_area_created_by' => Auth::id(),
                        'm_area_created_at' => Carbon::now(),
                    );
                    DB::table('m_area')->insert($data);
                } elseif ($request->action == 'edit') {
                    $this->validate(
                        $request,
                        [
                            'm_area_nama' => 'required|unique:m_area',
                            'm_area_code' => 'required|unique:m_area',
                        ]
                    );
                    $data = array(
                        'm_area_nama'    =>    $request->m_area_nama,
                        'm_area_code'    =>    $request->m_area_code,
                        'm_area_updated_by' => Auth::id(),
                        'm_area_updated_at' => Carbon::now(),
                    );
                    DB::table('m_area')->where('m_area_id', $request->id)
                        ->update($data);
                } else {
                    $data = array(
                        'm_area_deleted_at' => Carbon::now(),
                        'm_area_deleted_by' => Auth::id()
                    );
                    DB::table('m_area')
                        ->where('m_area_id', $request->id)
                        ->update($data);
                }
            }
            return response()->json(['message' => 'Data Duplicate !', $data->$request->errors()], 200);
        }
    }
}
