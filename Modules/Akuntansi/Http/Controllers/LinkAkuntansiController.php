<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $data  = new stdClass();
        $data->link = DB::table('link_akt')
            ->select('link_akt_m_rekening_id', 'link_akt_list_akt_id')
            ->whereNull('link_akt_deleted_at')->orderBy('link_akt_id', 'asc')->get();
        $data->list = DB::table('link_akt')->rightJoin('list_akt', 'list_akt_id', 'link_akt_list_akt_id')
            ->select('list_akt_id', 'list_akt_nama')->orderBy('list_akt_id', 'asc')
            ->get();
        $data->rekening = DB::table('link_akt')->rightJoin('m_rekening', 'm_rekening_id', 'link_akt_m_rekening_id')
            ->select()
            ->select('m_rekening_id', 'm_rekening_nama', 'm_rekening_kategori', 'm_rekening_no_akun', 'm_rekening_saldo')
            ->get();

        return view('akuntansi::master.link', compact('data'));
        // return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('akuntansi::create');
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
