<?php

namespace Modules\Akuntansi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama')
            ->get();

        $rekening = DB::table('m_rekening')
            ->where('m_rekening_m_w_id', $waroeng_id)
            ->get();
        return view('akuntansi::master.rekening', compact('waroeng', 'rekening', 'waroeng_id'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        foreach ($request->no_akun as $key => $value) {
            $data = array(
                'm_rekening_m_w_id' => $request->kode_waroeng,
                'm_rekening_kategori' => $request->kode_akun,
                'm_rekening_no_akun' => $request->no_akun[$key],
                'm_rekening_nama' => $request->nama_akun[$key],
                'm_rekening_saldo' => $request->saldo[$key],
                'm_rekening_created_by' => Auth::id(),
                'm_rekening_created_at' => Carbon::now(),
            );
            DB::table('m_rekening')->insert($data);
        }
        return redirect()->route('rekening.index', ['waroeng_id' => $request->kode_waroeng]);
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
