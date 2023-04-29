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
            if($request->status == 'asal'){
                $data->transaksi->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
                ->selectRaw("sum(rekap_tf_gudang_qty_keluar * rekap_tf_gudang_hpp) as total, rekap_tf_gudang_code, m_gudang_nama, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as rekap_tf_gudang_tgl_keluar_formatted, name")
                    ->groupby('rekap_tf_gudang_code', 'm_gudang_nama', 'rekap_tf_gudang_tgl_keluar_formatted', 'name');
                    if (strpos($request->tanggal, 'to') !== false) {
                        [$start, $end] = explode('to' ,$request->tanggal);
                        $data->transaksi->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), [$start, $end]);
                    } else {
                        $data->transaksi->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                    }
                    $data->transaksi = $data->transaksi->orderby('rekap_tf_gudang_tgl_keluar_formatted', 'ASC');
            } else {
                $data->transaksi->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_tujuan_code')
                ->selectRaw("sum(rekap_tf_gudang_qty_terima * rekap_tf_gudang_hpp) as total, rekap_tf_gudang_code, m_gudang_nama, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as rekap_tf_gudang_tgl_terima_formatted, name")
                    ->groupby('rekap_tf_gudang_code', 'm_gudang_nama', 'rekap_tf_gudang_tgl_terima_formatted', 'name');
                    if (strpos($request->tanggal, 'to') !== false) {
                        [$start, $end] = explode('to' ,$request->tanggal);
                        $data->transaksi->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), [$start, $end]);
                    } else {
                        $data->transaksi->where(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), $request->tanggal);
                    }
                    $data->transaksi = $data->transaksi->orderby('rekap_tf_gudang_tgl_terima_formatted', 'ASC');
            }
            $data->transaksi = $data->transaksi->orderby('rekap_tf_gudang_code', 'ASC')
            ->get();
            
        $data->detail = DB::table('rekap_tf_gudang')
            ->where('rekap_tf_gudang_m_w_id', $request->waroeng);
            if($request->pengadaan != 'all'){
                $data->detail->where('rekap_tf_gudang_created_by', $request->pengadaan);
            }
                if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to' ,$request->tanggal);
                    if($request->status == 'asal'){
                        $data->detail->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), [$start, $end]);
                    } else {
                        $data->detail->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), [$start, $end]);
                    }
                } else {
                    if($request->status == 'asal'){
                        $data->detail->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                    } else {
                        $data->detail->where(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), $request->tanggal);
                    }
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
                if($request->status == 'asal'){
                    if (strpos($request->tanggal, 'to') !== false) {
                        $dates = explode('to' ,$request->tanggal);
                        $asal->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $dates);
                    } else {
                        $asal->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                    }
                    $asal->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
                    ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, rekap_tf_gudang_tgl_keluar as tgl_keluar, SUM(rekap_tf_gudang_qty_keluar * rekap_tf_gudang_hpp) as total")
                    ->groupby('name', 'm_gudang_nama', 'tgl_keluar', 'rekap_tf_gudang_code')
                    ->orderBy('rekap_tf_gudang_code', 'ASC')
                    ->orderBy('tgl_keluar', 'ASC');
                } else {
                    if (strpos($request->tanggal, 'to') !== false) {
                        $dates = explode('to' ,$request->tanggal);
                        $asal->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), $dates);
                    } else {
                        $asal->where(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), $request->tanggal);
                    }
                    $asal->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_tujuan_code')
                    ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, rekap_tf_gudang_tgl_terima as tgl_tujuan, SUM(rekap_tf_gudang_qty_terima * rekap_tf_gudang_hpp) as total")
                    ->groupby('rekap_tf_gudang_code', 'name', 'm_gudang_nama', 'tgl_tujuan')
                    ->orderBy('rekap_tf_gudang_code', 'ASC')
                    ->orderBy('tgl_tujuan', 'ASC');
                }
                $asal = $asal->get();

            $data = array();
            foreach ($asal as $key => $valAsal) {
                $row = array();
                if($request->status == 'asal'){
                $row[] = date('d-m-Y H:i', strtotime($valAsal->tgl_keluar));
                } else {
                $row[] = date('d-m-Y H:i', strtotime($valAsal->tgl_tujuan));
                }
                $row[] = $valAsal->name;
                $row[] = $valAsal->m_gudang_nama;
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
                if($request->status == 'asal'){
                    $data->detail->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
                    ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as tgl_keluar, SUM(rekap_tf_gudang_hpp) as tot_hpp, SUM(rekap_tf_gudang_sub_total) as total")
                    ->groupby('name', 'm_gudang_nama', 'tgl_keluar', 'rekap_tf_gudang_code');
                } else {
                    $data->detail->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_tujuan_code')
                    ->selectRaw("rekap_tf_gudang_code, name, m_gudang_nama, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as tgl_tujuan, SUM(rekap_tf_gudang_hpp) as tot_hpp, SUM(rekap_tf_gudang_sub_total) as total")
                    ->groupby('rekap_tf_gudang_code', 'name', 'm_gudang_nama', 'tgl_tujuan');
                }
                $data->detail1 = $data->detail->where('rekap_tf_gudang_code', $id)->first();

        $data->detailz = DB::table('rekap_tf_gudang');
                if($request->status == 'asal'){
                    $data->detailz->select('rekap_tf_gudang_m_produk_nama', 'rekap_tf_gudang_qty_keluar', 'rekap_tf_gudang_satuan_keluar', 'rekap_tf_gudang_hpp')
                    ->orderBy('rekap_tf_gudang_m_produk_nama', 'ASC');
                } else {
                    $data->detailz->select('rekap_tf_gudang_m_produk_nama', 'rekap_tf_gudang_qty_terima', 'rekap_tf_gudang_satuan_terima', 'rekap_tf_gudang_hpp')
                    ->orderBy('rekap_tf_gudang_m_produk_nama', 'ASC');
                }
                $data->detail2 = $data->detailz->where('rekap_tf_gudang_code', $id)
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
            $data['all'] = ['All Waroeng'];
        }
        return response()->json($data);
    }

    public function tampil_harian(Request $request)
    {
        $gudang_harian = DB::table('rekap_tf_gudang')
            ->join('users', 'users_id', 'rekap_tf_gudang_created_by')
            ->join('m_w', 'm_w_id', 'rekap_tf_gudang_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id');
            if($request->area != 'all'){
                $gudang_harian->where('m_w_m_area_id', $request->area);
                if($request->waroeng != 'all'){
                    $gudang_harian->where('rekap_tf_gudang_m_w_id', $request->waroeng);
                }
            }
            if($request->show_pengadaan == 'ya'){
                if($request->pengadaan != 'all'){
                    $gudang_harian->where('rekap_tf_gudang_created_by', $request->pengadaan);
                }
            }
            if (strpos($request->tanggal, 'to') !== false) {
                $dates = explode('to' ,$request->tanggal);
                if($request->status == 'asal'){
                    $gudang_harian->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $dates);
                } else {
                    $gudang_harian->whereBetween(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), $dates);
                }
            } else {
                if($request->status == 'asal'){
                    $gudang_harian->where(DB::raw('DATE(rekap_tf_gudang_tgl_keluar)'), $request->tanggal);
                } else {
                    $gudang_harian->where(DB::raw('DATE(rekap_tf_gudang_tgl_terima)'), $request->tanggal);
                }
            }
            if($request->status == 'asal'){
                $gudang_harian = $gudang_harian->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_asal_code')
                ->selectRaw("m_gudang_nama, m_area_nama, m_w_nama, name, to_char(rekap_tf_gudang_tgl_keluar, 'DD-MM-YYYY') as tanggal, SUM(rekap_tf_gudang_qty_keluar * rekap_tf_gudang_hpp) as total")
                ->groupby('tanggal', 'm_area_nama', 'm_w_nama', 'name', 'm_gudang_nama')
                ->orderBy('tanggal', 'ASC');
            } else {
                $gudang_harian = $gudang_harian->join('m_gudang', 'm_gudang_code', 'rekap_tf_gudang_tujuan_code')
                ->selectRaw("m_gudang_nama, m_area_nama, m_w_nama, name, to_char(rekap_tf_gudang_tgl_terima, 'DD-MM-YYYY') as tanggal, SUM(rekap_tf_gudang_qty_terima * rekap_tf_gudang_hpp) as total")
                ->groupby('tanggal', 'm_area_nama', 'm_w_nama', 'name', 'm_gudang_nama')
                ->orderBy('tanggal', 'ASC');
            }
            $gudang_harian = $gudang_harian->get();
        
        $data =[];
            foreach ($gudang_harian as $valHarian){
                $row = array();
                $row[] = $valHarian->tanggal;
                $row[] = $valHarian->m_area_nama;
                $row[] = $valHarian->m_w_nama;
                if($request->show_pengadaan == 'ya'){
                $row[] = $valHarian->name;
                }
                $row[] = $valHarian->m_gudang_nama;
                $row[] = number_format($valHarian->total);
                $data[] = $row;
            }
        
        $output = array("data" => $data);
        return response()->json($output);
    }

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
