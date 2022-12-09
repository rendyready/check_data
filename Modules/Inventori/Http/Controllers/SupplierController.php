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
            $data[] = $row;
            $output = array("data" => $data);
            return response()->json($output);
        }
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
