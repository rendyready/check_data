<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inventori::m_supplier');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function data()
    {
        $get = DB::table('m_supplier')->get();
        $no = 0;
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $value->m_supplier_code;
            $row[] = $value->m_supplier_nama;
            $row[] = $value->m_supplier_alamat;
            $row[] = $value->m_supplier_kota;
            $row[] = $value->m_supplier_telp;
            $row[] = $value->m_supplier_ket;
            $row[] = $value->m_supplier_saldo_awal;
            $row[] = $value->m_supplier_rek.'-'.$value->m_supplier_rek_nama.'-'.$value->m_supplier_bank_nama;
            $row[] = "<button class='btn btn-sm buttonEdit btn-success'><i class='fa fa-pencil'></i></button>";
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
    public function simpan(Request $request)
    {
        $code = DB::table('m_supplier')->orderBy('m_supplier_id','desc')->get();
        $nocode = (empty($code->m_rekap_code)) ? "500001" : $code->m_supplier_code+1;
        if($request->ajax())
    	{
            if ($request->action == 'add') {
                $data = array(
                    'm_supplier_code'	=>	$nocode,
                    'm_supplier_nama'	=>	$request->m_supplier_nama,
                    'm_supplier_alamat'	=>	$request->m_supplier_alamat,
                    'm_supplier_kota'	=>	$request->m_supplier_kota,
                    'm_supplier_telp'	=>	$request->m_supplier_telp,
                    'm_supplier_ket'	=>	$request->m_supplier_ket,
                    'm_supplier_rek'	=>	$request->m_supplier_rek,
                    'm_supplier_rek_nama'	=>	$request->m_supplier_rek_nama,
                    'm_supplier_bank_nama'	=>	$request->m_supplier_bank_nama,
                    'm_supplier_saldo_awal'	=>	$request->m_supplier_saldo_awal,
                    'm_supplier_created_by' => Auth::id(),
                    'm_supplier_created_at' => Carbon::now(),
                );
                DB::table('m_supplier')->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_supplier_code'	=>	$request->m_supplier_code,
                    'm_supplier_nama'	=>	$request->m_supplier_nama,
                    'm_supplier_alamat'	=>	$request->m_supplier_alamat,
                    'm_supplier_kota'	=>	$request->m_supplier_kota,
                    'm_supplier_telp'	=>	$request->m_supplier_telp,
                    'm_supplier_ket'	=>	$request->m_supplier_ket,
                    'm_supplier_rek'	=>	$request->m_supplier_rek,
                    'm_supplier_rek_nama'	=>	$request->m_supplier_rek_nama,
                    'm_supplier_bank_nama'	=>	$request->m_supplier_bank_nama,
                    'm_supplier_saldo_awal'	=>	$request->m_supplier_saldo_awal,
                    'm_supplier_updated_by' => Auth::id(),
                    'm_supplier_updated_at' => Carbon::now(),
                );
                DB::table('m_supplier')->where('m_supplier_id',$request->m_supplier_id)
                ->update($data);
            }else {
                $softdelete = array('m_supplier_deleted_at' => Carbon::now());
    			DB::table('m_supplier')
    				->where('m_supplier_id', $request->m_supplier_id)
    				->update($softdelete);
            }
    		return response()->json($request);
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
