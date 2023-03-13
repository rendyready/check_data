<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            ->get();
        $data->produk = DB::table('m_produk')->where('m_produk_m_klasifikasi_produk_id',4)->get();
        $data->bb = DB::table('m_produk')->whereNotIn('m_produk_m_klasifikasi_produk_id',[4])->get();
        return view('master::m_resep', compact('data'));
        // return $data;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {   
        $waroeng_id = Auth::user()->waroeng_id;
        $produk = DB::table('m_produk')->where('m_produk_code',$request->m_resep_m_produk_code)->first();
        $data = DB::table('m_resep')->insert([
            "m_resep_code" => $this->getNextId('m_resep',$waroeng_id),
            "m_resep_m_produk_code" => $request->m_resep_m_produk_code,
            "m_resep_m_produk_nama" => $produk->m_produk_nama,
            "m_resep_keterangan" => $request->m_resep_keterangan,
            "m_resep_status" => $request->m_resep_status,
            "m_resep_created_by" => Auth::id(),
            "m_resep_created_at" => Carbon::now(),
        ]);
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function list($id)
    {
        $data = DB::table('m_resep')->where('m_resep_code', $id)->first();
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
        $produk = DB::table('m_produk')->where('m_produk_code',$request->m_resep_m_produk_code)->first();
        DB::table('m_resep')->where('m_resep_code', $request->id)
            ->update([
                "m_resep_m_produk_code" => $request->m_resep_m_produk_code,
                "m_resep_m_produk_nama" => $produk->m_produk_nama,
                "m_resep_keterangan" => $request->m_resep_keterangan,
                "m_resep_status" => $request->m_resep_status,
                "m_resep_updated_by" => Auth::id(),
                "m_resep_updated_at" => Carbon::now(),
            ]);
        return Redirect::route('m_resep.index');
    }
    public function detail($id)
    {
        $detail = DB::table('m_resep_detail')->where('m_resep_detail_m_resep_code', $id)->get();
        $data = array();
        $no = 1;
        foreach ($detail as $key) {
            $row = array();
            $row[] = $no++;
            $row[] = $key->m_resep_detail_m_produk_nama;
            $row[] = $key->m_resep_detail_bb_qty;
            $row[] = $key->m_resep_detail_satuan;
            $row[] = $key->m_resep_detail_standar_porsi;
            $row[] = $key->m_resep_detail_ket;
            $row[] = '<a class="btn btn-info btn-sm" onclick="editdetail('.$key->m_resep_detail_id.')"><i class="fa fa-edit"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            $produk = DB::table('m_produk')->where('m_produk_code',$request->m_resep_detail_bb_code)->first();
            $kode_satuan = DB::table('m_satuan')->where('m_satuan_id',$request->m_resep_detail_m_satuan_id)->first();
            if ($request->action == 'add') {
                $data = array(
                    'm_resep_detail_id' => $this->getMasterId('m_resep_detail'),
                    'm_resep_detail_m_resep_code'    =>    $request->id,
                    'm_resep_detail_bb_code'    =>    $request->m_resep_detail_bb_code,
                    'm_resep_detail_m_produk_nama' => $produk->m_produk_nama,
                    'm_resep_detail_bb_qty'    =>    $request->m_resep_detail_bb_qty,
                    'm_resep_detail_m_satuan_id' =>    $request->m_resep_detail_m_satuan_id,
                    'm_resep_detail_standar_porsi' => $request->m_resep_detail_standar_porsi,
                    'm_resep_detail_satuan' => $kode_satuan->m_satuan_kode,
                    'm_resep_detail_ket' => $request->m_resep_detail_ket,
                    'm_resep_detail_created_by' => Auth::id(),
                    'm_resep_detail_created_at' => Carbon::now(),
                );
                DB::table('m_resep_detail')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_resep_detail_id' => $request->m_resep_detail_id,
                    'm_resep_detail_bb_code'    =>    $request->m_resep_detail_bb_code,
                    'm_resep_detail_m_produk_nama' => $produk->m_produk_nama,
                    'm_resep_detail_bb_qty'    =>    $request->m_resep_detail_bb_qty,
                    'm_resep_detail_m_satuan_id' =>    $request->m_resep_detail_m_satuan_id,
                    'm_resep_detail_satuan' => $request->m_resep_detail_satuan,
                    'm_resep_detail_standar_porsi' => $request->m_resep_detail_standar_porsi,
                    'm_resep_detail_ket' => $request->m_resep_detail_ket,
                    'm_resep_detail_updated_by' => Auth::id(),
                    'm_resep_detail_updated_at' => Carbon::now(),
                );
                DB::table('m_resep_detail')->where('m_resep_detail_id', $request->m_resep_detail_id)
                    ->update($data);
                $resep_code = DB::table('m_resep_detail')->where('m_resep_detail_id',$request->m_resep_detail_id)->first();
                DB::table('m_resep')->where('m_resep_code')->where('m_resep_code',$resep_code->m_resep_detail_m_resep_code)
                ->update(['m_resep_updated_by' => Auth::id(),'m_resep_updated_at' => Carbon::now()]);
            }
            return response()->json($request);
        }
    }
    public function list_detail($id)
    {
        $data = DB::table('m_resep_detail')->where('m_resep_detail_id',$id)->first();
        return response()->json($data);
    }
}
