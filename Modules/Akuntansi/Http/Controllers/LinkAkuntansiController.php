<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class LinkAkuntansiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $list = DB::table('m_link_akuntansi')
            ->select('m_link_akuntansi_nama', 'm_rekening_nama', 'm_rekening_code', 'm_rekening_id', 'm_link_akuntansi_id')
            ->leftjoin('m_rekening', 'm_rekening_id', 'm_link_akuntansi_m_rekening_id')
            ->orderBy('m_link_akuntansi_id', 'asc')
            ->distinct()
            ->get();

        return view('akuntansi::link', compact('list'));
    }

    public function list()
    {
        $list2 = DB::table('m_rekening')
            ->select('m_rekening_code', 'm_rekening_id', 'm_rekening_nama')
            ->orderBy('m_rekening_code', 'asc')
            ->distinct('m_rekening_code')
            ->get();
        $data = array();
        foreach ($list2 as $val) {
            $data[$val->m_rekening_id] = [$val->m_rekening_nama];
            // $data[$val->m_rekening_code] = [$val->m_rekening_nama];
        }

        return response()->json($data);
    }

    public function rekeninglink(Request $request)
    {
        $rekening = DB::table('m_rekening')
            ->where('m_rekening_id', $request->data)
            ->select('m_rekening_id', 'm_rekening_code')->first();

        return response()->json($rekening);
    }

    public function update(Request $request)
    {
        $rekening_id = $request->no_rekening;

        $update = DB::table('m_link_akuntansi')
            ->where('m_link_akuntansi_id', $request->id)
            ->update(['m_link_akuntansi_m_rekening_id' => $rekening_id]);

        if ($update) {
            return response()->json(['messages' => 'Berhasil Update', 'type' => 'success']);
        } else {
            return response()->json(['messages' => 'Gagal Update', 'type' => 'error']);
        }
    }
}
