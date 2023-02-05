<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use stdClass;

class LinkAkuntansiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $list = DB::table('list_akt')
            ->select('list_akt_nama', 'list_akt_m_rekening_id', 'm_rekening_nama', 'list_akt_id', 'm_rekening_no_akun')
            ->leftjoin('m_rekening', 'm_rekening_no_akun', 'list_akt_m_rekening_id')
            ->whereNull('list_akt_deleted_at')
            ->orderBy('list_akt_id', 'asc')
            ->distinct()
            ->get();

        // return response()->json($list);
        return view('akuntansi::link', compact('list'));
    }

    public function list()
    {
        $list2 = DB::table('m_rekening')
            ->select('m_rekening_no_akun', 'm_rekening_id', 'm_rekening_nama')
            ->orderBy('m_rekening_no_akun', 'asc')
            ->distinct('m_rekening_no_akun')
            ->get();
        $data = array();
        foreach ($list2 as $val) {
            $data[$val->m_rekening_no_akun] = [$val->m_rekening_nama];
        }

        return response()->json($data);
    }


    public function rekeninglink(Request $request)
    {
        $rekening = DB::table('m_rekening')
            ->where('m_rekening_no_akun', $request->data)
            ->select('m_rekening_no_akun')->first();

        return  response()->json($rekening);
    }

    public function update(Request $request)
    {
        $norek = $request->list_akt_m_rekening_id;
        $update = DB::table('list_akt')
            ->where('list_akt_id', $request->list_akt_id)
            ->update(['list_akt_m_rekening_id' => $norek]);

        return response()->json([ 'msg' => 'Berhasil Update' . $norek]);

    }

    public function show($id)
    {
        return view('akuntansi::show');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('akuntansi::edit');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
