<?php

namespace Modules\Akuntansi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if (empty($request->waroeng_id)) {
            $waroeng_id = Auth::user()->waroeng_id;
        } else {
            $waroeng_id = $request->waroeng_id;
        }

        $rl = DB::table('m_rekening')->select('m_rekening_kategori', 'm_rekening_nama', 'm_rekening_no_akun', 'm_rekening_saldo')
            ->orderBy('m_rekening_kategori')->get();

        $mr = DB::table('m_rekening')
            ->rightJoin('m_w', 'm_w_id', 'm_rekening_m_w_id')
            ->select('m_rekening_id', 'm_rekening_kategori', 'm_rekening_no_akun', 'm_rekening_nama', 'm_rekening_saldo',)
            ->whereNull('m_rekening_deleted_at')->orderBy('m_w_code', 'asc')
            ->get();
        $mw = DB::table('m_w')->select('m_w_id', 'm_w_nama', 'm_w_code',)->orderBy('m_w_code', 'asc')->get();
        return view('akuntansi::master.rekening', compact('mr', 'mw'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function srcRekening(Request $request)
    {
        // $value = $request->m_rekening_kategori;
        $value = "aktiva lancar";
        $data = DB::table('m_rekening')->join('m_w', 'm_w_id', 'm_rekening_m_w_id')
            ->select('m_rekening_kategori', 'm_rekening_no_akun', 'm_rekening_nama', 'm_rekening_saldo')
            ->where('m_rekening_kategori', $request->m_rekening_kategori)
            ->where('m_rekening_m_w_id', $request->m_rekening_m_w_id)
            ->orderBy('m_w_code', 'asc')->get();
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
        foreach ($request->m_rekening_no_akun as $key => $value) {
            $data = array(
                'm_rekening_m_w_id' => $request->m_rekening_m_w_id,
                'm_rekening_kategori' => $request->m_rekening_kategori,
                'm_rekening_no_akun' => $request->m_rekening_no_akun[$key],
                'm_rekening_nama' => $request->m_rekening_nama[$key],
                'm_rekening_saldo' => $request->m_rekening_saldo[$key],
                'm_rekening_created_at' => Carbon::now(),
                'm_rekening_created_by' => Auth::id(),
            );
                DB::table('m_rekening')->insert($data);
        }
        return response()->json(['message'=> 'Berhasil Menambakan','type'=>'success']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show()
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
