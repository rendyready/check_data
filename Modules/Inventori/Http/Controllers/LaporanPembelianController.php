<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class LaporanPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

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
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
            $data['all'] = 'All Operator';
        }
        return response()->json($data);
    }

    public function lap_detail()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('inventori::lap_pembelian_detail', compact('data'));
    }

    public function tampil_detail(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_beli')
            ->join('users', 'users_id', 'rekap_beli_created_by')
            ->where('rekap_beli_m_w_id', $request->waroeng);
                if($request->pengadaan != 'all'){
                    $data->transaksi_rekap->where('rekap_beli_created_by', $request->pengadaan);
                }
            $data->transaksi_rekap2 = $data->transaksi_rekap->whereBetween('rekap_beli_tgl', $dates)
                ->orderby('rekap_beli_tgl', 'ASC')
                ->orderby('rekap_beli_code', 'ASC')
                ->get();
        $data->detail_nota = DB::table('rekap_beli_detail')
            ->orderby('rekap_beli_detail_m_produk_nama', 'ASC')
            ->get();
       
        return response()->json($data);
    }

    public function lap_rekap()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        $data->rekap_beli = DB::table('rekap_beli')
            ->get();
        return view('inventori::lap_pembelian_rekap', compact('data'));
    }

    public function tampil_rekap(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        $get = DB::table('rekap_beli')
                ->join('users', 'users_id', 'rekap_beli_created_by')
                ->where('rekap_beli_m_w_id', $request->waroeng);
                if($request->pengadaan != 'all'){
                    $get->where('rekap_beli_created_by', $request->pengadaan);
                }
                $get2 = $get->whereBetween('rekap_beli_tgl', $dates)
                ->orderBy('rekap_beli_tgl', 'ASC')
                ->orderBy('rekap_beli_code', 'ASC')
                ->get();

            $data = array();
            foreach ($get2 as $key => $value) {
                $row = array();
                $row[] = date('d-m-Y', strtotime($value->rekap_beli_tgl));
                $row[] = $value->name;
                $row[] = $value->rekap_beli_code;
                $row[] = $value->rekap_beli_supplier_nama;
                $row[] = $value->rekap_beli_supplier_alamat;
                $row[] = rupiah($value->rekap_beli_sub_tot, 0);
                $row[] = number_format($value->rekap_beli_disc ?? 0);
                $row[] = rupiah($value->rekap_beli_disc_rp, 0);
                $row[] = number_format($value->rekap_beli_ppn ?? 0);
                $row[] = rupiah($value->rekap_beli_ppn_rp, 0);
                $row[] = rupiah($value->rekap_beli_ongkir, 0);
                $row[] = rupiah($value->rekap_beli_tot_nom, 0);
                $row[] = rupiah($value->rekap_beli_terbayar, 0);
                $row[] = rupiah($value->rekap_beli_tersisa, 0);
                $row[] = $value->rekap_beli_ket;
                $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$value->rekap_beli_code.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
                $data[] = $row;
            }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function detail_rekap($id)
    {
        $data = new \stdClass();
        $data->rekap_beli = DB::table('rekap_beli')
                ->join('users', 'users_id', 'rekap_beli_created_by')
                ->where('rekap_beli_code', $id)
                ->first();
        $data->rekap_detail = DB::table('rekap_beli_detail')
            ->where('rekap_beli_detail_rekap_beli_code', $id)
            ->get();
        return response()->json($data);
    }

    public function lap_harian()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('inventori::lap_pembelian_harian', compact('data'));
    }

    public function select_waroeng_harian(Request $request)
    {
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code')
            ->where('m_w_m_area_id', $request->id_area)
            ->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
            $data['all'] = 'All Waroeng';
        }
        return response()->json($data);
    }

    public function harian_rekap(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);

        if($request->show_pengadaan == 'ya'){
        $rekap2 = DB::table('rekap_beli')
            ->join('users', 'users_id', 'rekap_beli_created_by')
            ->join('m_w', 'm_w_id', 'rekap_beli_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id');
            if($request->area != '0'){
                $rekap2->where('m_w_m_area_id', $request->area);
                if($request->waroeng != 'all'){
                    $rekap2->where('rekap_beli_m_w_id', $request->waroeng);
                }
            }
            if($request->pengadaan != 'all'){
                $rekap2->where('rekap_beli_created_by', $request->pengadaan);
            }
            $rekap = $rekap2->whereBetween('rekap_beli_tgl', $dates)
                ->selectRaw('SUM(rekap_beli_tot_nom) as total, SUM(rekap_beli_tersisa) as kurang, SUM(rekap_beli_terbayar) as bayar, m_area_nama, m_w_nama, name, rekap_beli_tgl')
                ->groupby('rekap_beli_tgl', 'm_area_nama', 'm_w_nama', 'name')
                ->orderBy('rekap_beli_tgl', 'ASC')
                ->get();
        } else {
        $rekap2 = DB::table('rekap_beli')
                        ->join('users', 'users_id', 'rekap_beli_created_by')
                        ->join('m_w', 'm_w_id', 'rekap_beli_m_w_id')
                        ->join('m_area', 'm_area_id', 'm_w_m_area_id');
            if($request->area != '0'){
                $rekap2->where('m_area_id', $request->area);
                if($request->waroeng != 'all'){
                    $rekap2->where('rekap_beli_m_w_id', $request->waroeng);
                }
            }
            $rekap = $rekap2->whereBetween('rekap_beli_tgl', $dates)
                ->selectRaw('SUM(rekap_beli_tot_nom) as total, SUM(rekap_beli_tersisa) as kurang, SUM(rekap_beli_terbayar) as bayar, m_area_nama, m_w_nama, rekap_beli_tgl')
                ->groupby('rekap_beli_tgl', 'm_area_nama', 'm_w_nama')
                ->orderBy('rekap_beli_tgl', 'ASC')
                ->get();
            }

        $data =[];
        if($request->show_pengadaan == 'ya'){
            foreach ($rekap as $valRekap){
                $row = array();
                $row[] = $valRekap->rekap_beli_tgl;
                $row[] = $valRekap->m_area_nama;
                $row[] = $valRekap->m_w_nama;
                $row[] = $valRekap->name;
                $row[] = rupiah($valRekap->total, 0);
                $row[] = rupiah($valRekap->bayar, 0);
                $row[] = rupiah($valRekap->kurang, 0);
                $data[] = $row;
            }
        } else {
            foreach ($rekap as $valRekap){
                $row = array();
                $row[] = $valRekap->rekap_beli_tgl;
                $row[] = $valRekap->m_area_nama;
                $row[] = $valRekap->m_w_nama;
                $row[] = rupiah($valRekap->total, 0);
                $row[] = rupiah($valRekap->bayar, 0);
                $row[] = rupiah($valRekap->kurang, 0);
                $data[] = $row;
            }
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
