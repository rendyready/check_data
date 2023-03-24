<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class LaporanKeluarGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inventori::index');
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
        return view('inventori::lap_keluar_gudang_detail', compact('data'));
    }

    public function tampil_detail(Request $request)
    {
        [$start, $end] = explode('to' ,$request->tanggal);
        $startDate =  date('Y-m-d', strtotime($start));
        $endDate =  date('Y-m-d', strtotime($end));
        $data = new \stdClass();
        if($request->status == 'asal'){
        $data->transaksi = DB::table('rekap_tf_gudang')
            ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->join('m_w', 'm_w_id', 'rekap_tf_gudang_m_w_id')
            ->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng)
            ->where('rekap_tf_gudang_created_by', $request->pengadaan)
            ->whereBetween('rekap_tf_gudang_tgl_keluar', [$startDate, $endDate])
            ->selectRaw("sum(rekap_tf_gudang_sub_total) as total, rekap_tf_gudang_code, m_gudang_nama, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as rekap_tf_gudang_tgl_keluar_formatted, name")
            ->groupby('rekap_tf_gudang_code', 'm_gudang_nama', 'rekap_tf_gudang_tgl_keluar_formatted', 'name')
            ->orderby('rekap_tf_gudang_tgl_keluar_formatted', 'ASC')
            ->orderby('rekap_tf_gudang_code', 'ASC')
            ->get();
        $data->detail = DB::table('rekap_tf_gudang')
            ->select('rekap_tf_gudang_code', 'rekap_tf_gudang_m_produk_nama', 'rekap_tf_gudang_qty_keluar', 'rekap_tf_gudang_satuan_keluar', 'rekap_tf_gudang_hpp', 'rekap_tf_gudang_sub_total')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng)
            ->where('rekap_tf_gudang_created_by', $request->pengadaan)
            ->whereBetween('rekap_tf_gudang_tgl_keluar', [$startDate, $endDate])
            ->get();
        } else {
        $data->transaksi = DB::table('rekap_tf_gudang')
            ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->join('m_w', 'm_w_id', 'rekap_tf_gudang_m_w_id')
            ->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_tujuan_code')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng)
            ->where('rekap_tf_gudang_created_by', $request->pengadaan)
            ->whereBetween('rekap_tf_gudang_tgl_terima', [$startDate, $endDate])
            ->selectRaw("sum(rekap_tf_gudang_sub_total) as total, rekap_tf_gudang_code, m_gudang_nama, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as rekap_tf_gudang_tgl_terima_formatted, name")
            ->groupby('rekap_tf_gudang_code', 'm_gudang_nama', 'rekap_tf_gudang_tgl_terima_formatted', 'name')
            ->orderby('rekap_tf_gudang_tgl_terima_formatted', 'ASC')
            ->orderby('rekap_tf_gudang_code', 'ASC')
            ->get();
        $data->detail = DB::table('rekap_tf_gudang')
            ->select('rekap_tf_gudang_code', 'rekap_tf_gudang_m_produk_nama', 'rekap_tf_gudang_qty_terima', 'rekap_tf_gudang_satuan_terima', 'rekap_tf_gudang_hpp', 'rekap_tf_gudang_sub_total')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng)
            ->where('rekap_tf_gudang_created_by', $request->pengadaan)
            ->whereBetween('rekap_tf_gudang_tgl_keluar', [$startDate, $endDate])
            ->get();
        }
       
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
        $data->gudang = DB::table('rekap_tf_gudang')
            ->get();
        return view('inventori::lap_keluar_gudang_rekap', compact('data'));
    }

    public function tampil_rekap(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);
        if($request->status == 'asal'){
        $asal2 = DB::table('rekap_tf_gudang')
                ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
                ->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
                ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
                        if($request->pengadaan != 'all'){
                            $asal2->where('rekap_tf_gudang_created_by', $request->pengadaan);
                        }
                $asal = $asal2->whereBetween('rekap_tf_gudang_tgl_keluar', $dates)
                ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as tgl_keluar, SUM(rekap_tf_gudang_hpp) as tot_hpp, SUM(rekap_tf_gudang_sub_total) as total")
                ->groupby('rekap_tf_gudang_code', 'name', 'm_gudang_nama', 'tgl_keluar')
                ->orderBy('rekap_tf_gudang_code', 'ASC')
                ->orderBy('tgl_keluar', 'ASC')
                ->get();

            $data = array();
            foreach ($asal as $key => $valAsal) {
                $row = array();
                $row[] = date('d-m-Y', strtotime($valAsal->tgl_keluar));
                $row[] = $valAsal->rekap_tf_gudang_code;
                $row[] = $valAsal->name;
                $row[] = $valAsal->m_gudang_nama;
                $row[] = rupiah($valAsal->tot_hpp);
                $row[] = rupiah($valAsal->total);
                $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$valAsal->rekap_tf_gudang_code.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
                $data[] = $row;
            }
        } else {
        $tujuan2 = DB::table('rekap_tf_gudang')
            ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_tujuan_code')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
                    if($request->pengadaan != 'all'){
                        $tujuan2->where('rekap_tf_gudang_created_by', $request->pengadaan);
                    }
            $tujuan = $tujuan2->whereBetween('rekap_tf_gudang_tgl_terima', $dates)
            ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as tgl_tujuan, SUM(rekap_tf_gudang_hpp) as tot_hpp, SUM(rekap_tf_gudang_sub_total) as total")
            ->groupby('rekap_tf_gudang_code', 'name', 'm_gudang_nama', 'tgl_tujuan')
            ->orderBy('rekap_tf_gudang_code', 'ASC')
            ->orderBy('tgl_tujuan', 'ASC')
            ->get();

        $data = array();
        foreach ($tujuan as $key => $valTujuan) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($valTujuan->tgl_tujuan));
            $row[] = $valTujuan->rekap_tf_gudang_code;
            $row[] = $valTujuan->name;
            $row[] = $valTujuan->m_gudang_nama;
            $row[] = $valTujuan->tot_hpp;
            $row[] = $valTujuan->total;
            $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$valTujuan->rekap_tf_gudang_code.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
            $data[] = $row;
            }
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
        return view('inventori::lap_keluar_gudang_harian', compact('data'));
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
