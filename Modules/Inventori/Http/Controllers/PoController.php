<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class PoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {$data = new \stdClass();
        
        $get_max_id = DB::table('rekap_po')->orderBy('rekap_po_id','desc')->first();
        $user = Auth::user()->users_id;
        $data->code = (empty($get_max_id->rekap_po_id)) ? $urut = "200001". $user : $urut = substr($get_max_id->rekap_po_code,0,-1)+'1'. $user; 
        return view('inventori::form_po',compact('data'));
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $rekap_po = array(
            'rekap_po_code' => $request->rekap_po_code,
            'rekap_po_tgl' => $request->rekap_po_tgl,
            'rekap_po_supplier_id' => $request->rekap_po_supplier_id,
            'rekap_po_supplier_nama' => $request->rekap_po_supplier_nama,
            'rekap_po_supplier_telp' => $request->rekap_po_supplier_telp,
            'rekap_po_supplier_alamat' => $request->rekap_po_supplier_alamat,
            'rekap_po_m_w_id' => Auth::user()->waroeng_id,
            'rekap_po_created_at' => Carbon::now(),
            'rekap_po_created_by' => Auth::user()->users_id

        );

        $insert = DB::table('rekap_po')->insert($rekap_po);
        foreach ($request->rekap_po_detail_qty as $key => $value) {
            $produk = DB::table('m_produk')
            ->where('m_produk_id',$request->rekap_po_detail_m_produk_id[$key])
            ->first();
            $data = array(
                'rekap_po_detal_rekap_po_code'=> $request->rekap_po_code,
                'rekap_po_detail_m_produk_id' => $request->rekap_po_detail_m_produk_id[$key],
                'rekap_po_detail_m_produk_code' => $produk->m_produk_code,
                'rekap_po_detail_m_produk_nama' => $produk->m_produk_nama,
                'rekap_po_detail_qty' => $request->rekap_po_detail_qty[$key],
                'rekap_po_detail_satuan' => $request->rekap_po_detail_catatan[$key],
                'rekap_po_detail_catatan' => $request->rekap_po_detail_catatan[$key],
                'rekap_po_detail_created_by' => Auth::user()->users_id,
                'rekap_po_detail_created_at' => Carbon::now()
            );
            DB::table('rekap_po_detail')->insert($data);
        }
        return redirect()->back()->with('success', 'your message,here'); 
    }
}
