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

        // return response()->json([$data, $list]);
        return view('akuntansi::master.link', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {

        //mode awal
        // $data = DB::table('link_akt')->rightJoin('m_rekening', 'm_rekening_id', 'link_akt_m_rekening_id')
        //     ->select('m_rekening_id', 'm_rekening_nama', 'm_rekening_kategori', 'm_rekening_no_akun', 'm_rekening_saldo')
        //     ->get();

        // return response()->json(['data' => $data]);

        $list = DB::table('link_akt')
            ->rightJoin('m_rekening', 'm_rekening_id', 'link_akt_m_rekening_id')
            ->select('m_rekening_nama', 'm_rekening_no_akun',)
            ->orderBy('m_rekening_no_akun', 'asc')
            ->get();
        foreach ($list as $val) {
            $data[] = $val->m_rekening_no_akun;
            return response()->json($data);
        }
    }

    public function listIndex()
    {
        $list = DB::table('list_akt')->select('list_akt_nama',)->get();

        $no = 0;
        $data = array();
        $data = array();
        foreach ($list as $val) {
            $rekening = DB::table('m_rekening')->select('m_rekening_nama','m_rekening_no_akun')->get();
            $we = array();
            $no++;
            $we[] = $no;
            $we[] = $val->list_akt_nama;
            $we[] = '<select class="js-select2 form-select masterRekening" id="masterRekening" name="example-select2" style="width: 100%;" data-placeholder="Choose one.."></select>';
            $we[] = '
              <select class="js-select2 form-select" id="example-select2" name="example-select2" style="width: 100%;" data-placeholder="Choose one..">
                <option ></option>
                <option value="1">HTML</option>
                <option value="2">CSS</option>
                <option value="3">JavaScript</option>
                <option value="4">PHP</option>
                <option value="5">MySQL</option>
                <option value="6">Ruby</option>
                <option value="7">Angular</option>
                <option value="8">React</option>
                <option value="9">Vue.js</option>
              </select>
            ';
            $data[] = $we;
        }

        $output = array('data' => $data);
        return response()->json($output);
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
