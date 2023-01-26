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
            ->select('list_akt_nama')
            ->whereNull('list_akt_deleted_at')->orderBy('list_akt_id', 'asc')->get();

        $data = DB::table('link_akt')->rightJoin('list_akt', 'list_akt_id', 'link_akt_list_akt_id')
            ->select('list_akt_id', 'list_akt_nama',)
            ->whereNull('link_akt_deleted_at')->orderBy('list_akt_id', 'asc')
            ->get();

        // return response()->json([$link, $data]);
        return view('akuntansi::link', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {
        $list2 = DB::table('m_rekening')
            ->select('m_rekening_no_akun', 'm_rekening_id', 'm_rekening_nama')
            ->orderBy('m_rekening_no_akun', 'asc')
            ->distinct('m_rekening_no_akun')
            ->get();
        $data = array();
        foreach ($list2 as $val) {
            $data[$val->m_rekening_id] = [$val->m_rekening_nama];
        }

        return response()->json($data);
    }


    public function rekeninglink(Request $request)
    {
        $rekening = DB::table('m_rekening')
            ->where('m_rekening_id', $request->data)
            ->select('m_rekening_no_akun')->first();

        return  response()->json($rekening);
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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('akuntansi::show');
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
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
