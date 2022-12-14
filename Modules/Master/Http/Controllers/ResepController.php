<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ResepController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->resep = DB::table('m_resep')
            ->leftjoin('m_produk', 'm_resep_m_produk_id', 'm_produk_id')
            ->get();
        $data->produk = DB::table('m_produk')->get();
        return view('master::m_resep', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $value = [
            'm_produk_nama' => ['required', 'max:255'],
            'm_resep_keterangan' => ['required', 'max:255'],
        ];
        $validate = Validator::make($request, $value);
        if ($validate->fails()) {
            return response(['Errors' => $validate]);
        } else {
            //
        }
        $data = DB::table('m_resep')->insert([
            "m_resep_m_produk_id" => $request->m_resep_m_produk_id,
            "m_resep_keterangan" => $request->m_resep_keterangan,
            "m_resep_status" => $request->m_resep_status,
            "m_resep_created_by" => Auth::id(),
            "m_resep_created_at" => Carbon::now(),
        ]);
        return Redirect::route('m_resep.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function list($id)
    {
        $data = DB::table('m_resep')->where('m_resep_id', $id)->first();
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
        DB::table('m_resep')->where('m_resep_id', $request->id)
            ->update([
                "m_resep_m_produk_id" => $request->m_resep_m_produk_id,
                "m_resep_keterangan" => $request->m_resep_keterangan,
                "m_resep_status" => $request->m_resep_status,
                "m_resep_updated_by" => Auth::id(),
                "m_resep_updated_at" => Carbon::now(),
            ]);
        return Redirect::route('m_resep.index');
    }
    public function detail($id)
    {
        $detail = DB::table('m_resep_detail')->where('m_resep_detail_m_resep_id', $id)
            ->leftjoin('m_produk', 'm_resep_detail_bb_id', 'm_produk_id')
            ->leftjoin('m_satuan', 'm_resep_detail_m_satuan_id', 'm_satuan_id')
            ->select('m_resep_detail.*', 'm_produk_nama', 'm_satuan_kode')
            ->get();
        $data = array();
        $no = 0;
        foreach ($detail as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->m_produk_nama;
            $row[] = $key->m_resep_detail_bb_qty;
            $row[] = $key->m_satuan_kode;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $data = array(
                    'm_resep_detail_m_resep_id'    =>    $request->id,
                    'm_resep_detail_bb_id'    =>    $request->m_resep_detail_bb_id,
                    'm_resep_detail_bb_qty'    =>    $request->m_resep_detail_bb_qty,
                    'm_resep_detail_m_satuan_id' =>    $request->m_resep_detail_m_satuan_id,
                    'm_resep_detail_created_by' => Auth::id(),
                    'm_resep_detail_created_at' => Carbon::now(),
                );
                DB::table('m_resep_detail')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_resep_detail_m_resep_id'    =>    $request->id,
                    'm_resep_detail_bb_id'    =>    $request->m_resep_detail_bb_id,
                    'm_resep_detail_bb_qty'    =>    $request->m_resep_detail_bb_qty,
                    'm_resep_detail_m_satuan_id' =>    $request->m_resep_detail_m_satuan_id,
                    'm_resep_detail_updated_by' => Auth::id(),
                    'm_resep_detail_updated_at' => Carbon::now(),
                );
                DB::table('m_resep_detail')->where('m_resep_detail_id', $request->m_resep_detail_id)
                    ->update($data);
            }
            return response()->json($request);
        }
    }
    public function list_detail()
    {
        $data = new \stdClass();
        $satuan = DB::table('m_satuan')->get();
        $bb = DB::table('m_produk')->get();
        foreach ($satuan as $key => $v) {
            $data->satuan[$v->m_satuan_id] = $v->m_satuan_kode;
        }
        foreach ($bb as $key => $v) {
            $data->bb[$v->m_produk_id] = $v->m_produk_nama;
        }
        return response()->json($data);
    }
}
