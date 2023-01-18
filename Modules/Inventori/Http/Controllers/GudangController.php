<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng = DB::table('m_w')->select('m_w_id','m_w_nama')->get();
        $nama_gudang = DB::table('m_gudang_nama')->get();
        return view('inventori::m_gudang',compact('waroeng','nama_gudang'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {   $no =0;
        $gudang = DB::table('m_gudang')->
        join('m_w','m_w_id','m_gudang_m_w_id')->get();
        foreach ($gudang as $key) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = ucwords($key->m_gudang_nama);
            $row[] = $key->m_w_nama;
            // $row[] = '<a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="'.$key->m_gudang_id.'" title="Edit"><i class="fa fa-pencil"></i></a>';
            $data[] = $row;
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
        if($request->ajax())
    	{
            if ($request->action == 'add') {
                $validate = DB::table('m_gudang')
                ->where('m_gudang_m_w_id',$request->m_gudang_m_w_id)
                ->where('m_gudang_nama',strtolower($request->m_gudang_nama))->first();
                $data = array(
                    'm_gudang_m_w_id'	=>	$request->m_gudang_m_w_id,
                    'm_gudang_nama'	=>	strtolower($request->m_gudang_nama),
                    'm_gudang_created_by' => Auth::id(),
                    'm_gudang_created_at' => Carbon::now(),
                );
                if (empty($validate)) {
                    DB::table('m_gudang')->insert($data);
                    $masterbb = DB::table('m_produk')
                    ->select('m_produk_id')->get();
                    $gudang_id = DB::table('m_gudang')->max('m_gudang_id');
                    foreach ($masterbb as $key) {
                        $data_bb = array(
                            'm_stok_m_produk_id' => $key->m_produk_id,
                            'm_stok_gudang_id' => $gudang_id,
                            'm_stok_awal' => 0,
                            'm_stok_created_by' => Auth::id(),
                            'm_stok_created_at' => Carbon::now(),
                        );
                        DB::table('m_stok')->insert($data_bb);
                    }
                    
                    return response(['messages' => 'Berhasil Tambah Gudang !','type' => 'success']);
                } else {
                    return response(['messages' => 'Gagal Tambah Gudang Sudah Ada!','type'=> 'danger']);
                }
                DB::table('m_gudang')->insert($data);
            } elseif ($request->action == 'edit') {
                $validate = DB::table('m_gudang')
                ->where('m_gudang_m_w_id',$request->m_gudang_m_w_id)
                ->where('m_gudang_nama',strtolower($request->m_gudang_nama))->first();
                $data = array(
                    'm_gudang_m_w_id'	=>	$request->m_gudang_m_w_id,
                    'm_gudang_nama'	=>	strtolower($request->m_gudang_nama),
                    'm_gudang_updated_by' => Auth::id(),
                    'm_gudang_updated_at' => Carbon::now(),
                );
                if ($validate == null) {
                    DB::table('m_gudang')->where('m_gudang_id',$request->m_gudang_id)
                    ->update($data);
                    return response(['messages' => 'Berhasil Update Gudang !','type' => 'success']);
                } else {
                    return response(['messages' => 'Gagal Update Gudang Sudah Ada!','type'=> 'danger']);
                }
            }else {
                $softdelete = array('m_gudang_deleted_at' => Carbon::now());
    			DB::table('m_gudang')
    				->where('m_gudang_id', $request->m_gudang_id)
    				->update($softdelete);
            }
    		return response()->json($request);
    	}
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = DB::table('m_gudang')->where('m_gudang_id',$id)->first();
        return response()->json($data);
    }
}
