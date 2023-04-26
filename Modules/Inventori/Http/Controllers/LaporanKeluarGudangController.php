<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public function lap_detail()
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
        return view('inventori::lap_keluar_gudang_detail', compact('data'));
    }

    public function tampil_detail(Request $request)
    {
        $data = new \stdClass();
        $data->transaksi = DB::table('rekap_tf_gudang')
            ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->join('m_w', 'm_w_id', 'rekap_tf_gudang_m_w_id')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
            if($request->pengadaan != 'all'){
                $data->transaksi->where('rekap_tf_gudang_created_by', $request->pengadaan);
            }
                $data->transaksi->selectRaw("sum(rekap_tf_gudang_sub_total) as total, rekap_tf_gudang_code, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as tgl_keluar, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as tgl_terima, name")
                    ->groupby('rekap_tf_gudang_code', 'tgl_keluar', 'tgl_terima', 'name');
                    if (strpos($request->tanggal, 'to') !== false) {
                        [$start, $end] = explode('to' ,$request->tanggal);
                        $data->transaksi->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), [$start, $end]);
                    } else {
                        $data->transaksi->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                    }
                    $data->transaksi = $data->transaksi->orderby('tgl_keluar', 'ASC')
                    ->orderby('tgl_keluar', 'ASC')
                    ->orderby('rekap_tf_gudang_code', 'ASC')
                    ->get();
            
        $data->detail = DB::table('rekap_tf_gudang')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
            if($request->pengadaan != 'all'){
                $data->detail->where('rekap_tf_gudang_created_by', $request->pengadaan);
            }
                if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to' ,$request->tanggal);
                    $data->detail->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), [$start, $end]);
                } else {
                    $data->detail->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                }
            
            $data->detail = $data->detail->get();
       
        return response()->json($data);
    }

    public function lap_rekap()
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
        $data->gudang = DB::table('rekap_tf_gudang')
            ->get();
        return view('inventori::lap_keluar_gudang_rekap', compact('data'));
    }

    public function tampil_rekap(Request $request)
    {
        $asal = DB::table('rekap_tf_gudang')
                ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
                ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
                if($request->pengadaan != 'all'){
                    $asal->where('rekap_tf_gudang_created_by', $request->pengadaan);
                }
                    if (strpos($request->tanggal, 'to') !== false) {
                        $dates = explode('to' ,$request->tanggal);
                        $asal->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $dates);
                    } else {
                        $asal->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                    }
                    $asal ->selectRaw("rekap_tf_gudang_code, name, rekap_tf_gudang_tgl_keluar as tgl_keluar, rekap_tf_gudang_tgl_terima as tgl_tujuan, SUM(rekap_tf_gudang_hpp) as tot_hpp, SUM(rekap_tf_gudang_sub_total) as total, rekap_tf_gudang_satuan_keluar, rekap_tf_gudang_satuan_terima")
                    ->groupby('name', 'tgl_keluar', 'tgl_tujuan', 'rekap_tf_gudang_code', 'rekap_tf_gudang_satuan_keluar', 'rekap_tf_gudang_satuan_terima')
                    ->orderBy('rekap_tf_gudang_code', 'ASC')
                    ->orderBy('tgl_keluar', 'ASC');
                $asal = $asal->get();

            $data = array();
            foreach ($asal as $key => $valAsal) {
                $row = array();
                $row[] = date('d-m-Y H:i', strtotime($valAsal->tgl_keluar));
                $row[] = date('d-m-Y H:i', strtotime($valAsal->tgl_tujuan));
                $row[] = $valAsal->name;
                $row[] = number_format($valAsal->total);
                $row[] ='<a id="button_detail" class="btn btn-sm button_detail btn-info" value="'.$valAsal->rekap_tf_gudang_code.'" title="Detail Nota"><i class="fa-sharp fa-solid fa-file"></i></a>';
                $data[] = $row;
            }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function detail_rekap(Request $request, $id)
    {
        $data = new \stdClass();
        $data->detail = DB::table('rekap_tf_gudang')
                ->join('users', 'users_id', 'rekap_tf_gudang_created_by');
                    $data->detail->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
                    ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as tgl_keluar, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as tgl_tujuan, SUM(rekap_tf_gudang_hpp) as tot_hpp, SUM(rekap_tf_gudang_sub_total) as total")
                    ->groupby('name', 'm_gudang_nama', 'tgl_keluar', 'tgl_tujuan', 'rekap_tf_gudang_code');
                $data->detail1 = $data->detail->where('rekap_tf_gudang_code', $id)->first();

        $data->detail2 = DB::table('rekap_tf_gudang')
                ->orderBy('rekap_tf_gudang_m_produk_nama', 'ASC')
                ->where('rekap_tf_gudang_code', $id)
                ->get();

        return response()->json($data);
    }

    public function lap_harian()
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
