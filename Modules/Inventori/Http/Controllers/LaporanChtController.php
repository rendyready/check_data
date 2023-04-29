<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as kontrol;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class LaporanChtController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        return view('inventori::lap_cht', compact('data'));
    }

    public function select_waroeng(Request $request)
    {
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code')
            ->where('m_w_m_area_id', $request->id_area)
            ->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
        }
        return response()->json($data);
    }

    public function select_user(Request $request)
    {
        $user = DB::table('users')
        ->join('rekap_tf_gudang', 'rekap_tf_gudang_created_by', 'users_id')
        ->select('users_id', 'name');
        if(in_array(Auth::user()->waroeng_id, $this->get_akses_area())){
            $user->where('waroeng_id', $request->id_waroeng);
        } else {
            $user->where('waroeng_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to' ,$request->tanggal);
            $user->whereBetween(DB::raw('DATE(rekap_tf_gudang_created_at)'), [$start, $end]);
        } else {
            $user->where(DB::raw('DATE(rekap_tf_gudang_created_at)'), $request->tanggal);
        }
        $user1 = $user->orderBy('users_id', 'asc')
        ->get();

        $data = array();
        foreach ($user1 as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
    }

    public function select_bb(Request $request)
    {
        $bb = DB::table('rekap_beli_detail')
            ->where('rekap_beli_detail_created_by', $request->pengadaan)
            ->orderBy('rekap_beli_detail_id', 'asc')
            ->get();
        $data = array();
        foreach ($bb as $val) {
            $data['all'] = 'All Bahan Baku';
            $data[$val->rekap_beli_detail_m_produk_code] = [$val->rekap_beli_detail_m_produk_nama];
        }
        return response()->json($data);
    }

    public function tampil_cht(Request $request)
    {
        $cht = DB::table('rekap_beli_detail')
            ->join('rekap_beli', 'rekap_beli_code', 'rekap_beli_detail_rekap_beli_code')
            ->join('m_w', 'm_w_id', 'rekap_beli_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->join('users', 'users_id', 'rekap_beli_created_by');
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $cht->whereBetween('rekap_beli_tgl', [$start, $end]);
            } else {
                $cht->where('rekap_beli_tgl', $request->tanggal);
            }     
            if($request->area != 'all'){
                if($request->waroeng != 'all'){
                    $cht->where('rekap_beli_m_w_id', $request->waroeng);
                    if($request->pengadaan != 'all'){
                        $cht->where('rekap_beli_created_by', $request->pengadaan);
                        if($request->bb != 'all'){
                            $cht->where('rekap_beli_detail_m_produk_code', $request->bb);
                        }
                    }
                }
            }
            $cht = $cht->get();

        $data =[];
        foreach ($cht as $valCht){
                $row = array();
                $row[] = $valCht->m_area_nama;
                $row[] = $valCht->rekap_beli_waroeng;
                $row[] = $valCht->rekap_beli_tgl;
                $row[] = $valCht->name;
                $row[] = $valCht->rekap_beli_supplier_nama;
                $row[] = $valCht->rekap_beli_supplier_alamat;
                $row[] = $valCht->rekap_beli_detail_m_produk_nama;
                $row[] = number_format($valCht->rekap_beli_detail_qty);
                $row[] = number_format($valCht->rekap_beli_detail_terima_qty);
                $row[] = number_format($valCht->rekap_beli_detail_qty - $valCht->rekap_beli_detail_terima_qty);
                $data[] = $row;
            }
        
        $output = array("data" => $data);
        return response()->json($output);
    }

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
