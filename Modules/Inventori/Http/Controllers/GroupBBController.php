<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupBBController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $produk = DB::table('m_produk')->where('m_produk_m_klasifikasi_produk_id', 3)->get();
        $satuan = DB::table('m_satuan')->get();
        return view('inventori::m_grub_bb', compact('produk', 'satuan'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    function list() {
        $list = DB::table('m_std_bb_resep')
            ->leftJoin('m_produk AS produk_asal', 'm_std_bb_resep.m_std_bb_resep_m_produk_code_asal', '=', 'produk_asal.m_produk_code')
            ->leftJoin('m_produk AS produk_relasi', 'm_std_bb_resep.m_std_bb_resep_m_produk_code_relasi', '=', 'produk_relasi.m_produk_code')
            ->leftJoin('m_satuan', 'm_std_bb_resep_m_satuan_id', '=', 'm_satuan.m_satuan_id')
            ->select('m_std_bb_resep.*', 'produk_asal.m_produk_nama AS produk_asal_nama', 'produk_relasi.m_produk_nama AS produk_relasi_nama', 'm_satuan_kode')
            ->get();
        $data = array();
        $no = 1;
        foreach ($list as $key => $value) {
            $row = array();
            $row[] = $no;
            $row[] = $value->produk_asal_nama;
            $row[] = $value->produk_relasi_nama;
            $row[] = $value->m_std_bb_resep_qty;
            $row[] = $value->m_std_bb_resep_porsi;
            $row[] = $value->m_satuan_kode;
            $row[] = $value->m_std_bb_resep_gudang_status;
            $row[] = '<a class="btn btn-info btn-sm" onclick="editdetail(' . $value->m_std_bb_resep_id . ')"><i class="fa fa-edit"></i></a>';
            $data[] = $row;
            $no++;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function action(Request $request)
    {
        $cek_duplicate = DB::table('m_std_bb_resep')
            ->where('m_std_bb_resep_m_produk_code_asal', $request->m_std_bb_resep_m_produk_code_asal)
            ->where('m_std_bb_resep_m_produk_code_relasi', $request->m_std_bb_resep_m_produk_code_relasi)
            ->first();
        if ($request->ajax()) {
            if ($request->action == 'add') {
                if (!empty($cek_duplicate)) {
                    return response(['messages' => 'Grub BB  Sudah Ada!', 'type' => 'danger']);
                } else {
                    $data = $request->except('_token', 'action', 'id');
                    $data['m_std_bb_resep_created_by'] = Auth::user()->users_id;
                    $data['m_std_bb_resep_id'] = $this->getNextId('m_std_bb_resep', Auth::user()->waroeng_id);
                    $data['m_std_bb_resep_m_produk_nama_asal'] = $this->get_produk($data['m_std_bb_resep_m_produk_code_asal'])->m_produk_nama;
                    $data['m_std_bb_resep_m_produk_nama_relasi'] = $this->get_produk($data['m_std_bb_resep_m_produk_code_relasi'])->m_produk_nama;
                    DB::table('m_std_bb_resep')->insert($data);
                    return response(['messages' => 'Berhasil Tambah Grub BB', 'type' => 'success']);
                }
            } elseif ($request->action == 'edit') {
                $data = $request->except('_token', 'action');
                $data['m_std_bb_resep_updated_by'] = Auth::user()->users_id;
                $data['m_std_bb_resep_m_produk_nama_asal'] = $this->get_produk($data['m_std_bb_resep_m_produk_code_asal']);
                $data['m_std_bb_resep_m_produk_nama_relasi'] = $this->get_produk($data['m_std_bb_resep_m_produk_code_relasi']);
                DB::table('m_std_bb_resep')->where('m_std_bb_resep_id', $request->id)->update($data);
                return response(['messages' => 'Berhasil Ubah Grub BB', 'type' => 'success']);
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('inventori::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('inventori::edit');
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
