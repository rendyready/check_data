<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class KartuStockController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inventori::index');
    }

    public function kartu_stk()
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
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('inventori::lap_kartu_stock', compact('data'));
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

    public function select_gudang(Request $request)
    {
        $gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $request->waroeng)
            ->orderBy('m_gudang_id', 'asc')
            ->get();
        $data = array();
        foreach ($gudang as $val) {
            $data[$val->m_gudang_code] = [$val->m_gudang_nama];
            // $data['all'] = 'gudang utama & produksi waroeng';
        }

        return response()->json($data);
    }

    public function select_bb(Request $request)
    {
        $bb2 = DB::table('m_stok');
        if($request->gudang != 'all'){
            $bb2->where('m_stok_gudang_code', $request->gudang);
        } else {
            $bb2->whereIn('m_stok_gudang_code', ['60001',  '60002']);
        }
        $bb = $bb2->orderBy('m_stok_id', 'asc')
            ->get();
        $data = array();
        foreach ($bb as $val) {
            $data[$val->m_stok_m_produk_code] = [$val->m_stok_produk_nama];
            // $data['all'] = 'All Bahan Baku';
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
        //stokawal2
        $master_stok = DB::table('m_stok')
            ->select('m_stok_awal')
            ->where('m_stok_gudang_code', $request->gudang)
            ->where('m_stok_m_produk_code', $request->bb)
            ->first();

        //stok awal1
        $stok_awal = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            // ->select(DB::raw('SUM(m_stok_detail_masuk - m_stok_detail_keluar + m_stok_detail_so) as stok_awal'))
            ->select('m_stok_detail_saldo', 'm_stok_detail_id')
            ->where('m_stok_detail_m_produk_code', $request->bb)
            ->where('m_stok_detail_gudang_code', $request->gudang);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $stok_awal->where('m_stok_detail_tgl', '<', $start);
            } else {
                $stok_awal->where('m_stok_detail_tgl', '<', $request->tanggal);
            }
            // $stok_awal = $stok_awal->first();
            $stok_awal = $stok_awal->orderby('m_stok_detail_id', 'desc')->first();


        $stok = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->where('m_stok_detail_m_produk_code', $request->bb);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $stok->whereBetween('m_stok_detail_tgl', [$start, $end]);
            } else {
                $stok->where('m_stok_detail_tgl', $request->tanggal);
            }     
            $stok = $stok->where('m_area_id', $request->area)
            ->where('m_gudang_m_w_id', $request->waroeng)
            ->where('m_stok_detail_gudang_code', $request->gudang)
            ->orderby('m_stok_detail_created_at', 'ASC')
            ->get();
// return $stok_awal;
        $i = 0;
        $data = array();
        if(empty($stok_awal)){
            $stok_awal = 0;
        } else {
            $stok_awal = $stok_awal->m_stok_detail_saldo;
        }

        if($stok_awal == 0){
            $stokawal = $master_stok->m_stok_awal;
        } else {
            $stokawal = $stok_awal;
        }
        $row = array();
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $row[] = 'Stok Awal';
        $row[] = number_format($stokawal ?? 0);
        $row[] = '';
        $row[] = '';
        $row[] = '';
        $data[] = $row;
        foreach ($stok as $value) {
            // $stokawal = $stok_awal->stok_awal;
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->m_stok_detail_tgl));
            $row[] = $value->m_stok_detail_m_produk_nama;
            $row[] = number_format($value->m_stok_detail_masuk ?? 0);
            $row[] = number_format($value->m_stok_detail_keluar ?? 0);
            $row[] = number_format($value->m_stok_detail_so ?? 0);
            if($i == 0){
                $stokkeluar = $stokawal + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar + $value->m_stok_detail_so;
                $row[] = $stokkeluar;
                $i = 1;
            } else {
                $row[] = $stokkeluar + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar + $value->m_stok_detail_so;
                $stokkeluar = $stokkeluar + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar + $value->m_stok_detail_so;
            }
            $row[] = $value->m_stok_detail_satuan;
            $row[] = rupiah($value->m_stok_detail_hpp, 0);
            $row[] = $value->m_stok_detail_catatan;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function rekap_stk()
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
        $data->gudang = DB::table('m_gudang')
            ->orderby('m_gudang_id', 'ASC')
            ->where('m_gudang_m_w_id', $waroeng_id)
            ->get();
        $data->bb = DB::table('m_klasifikasi_produk')
            ->orderby('m_klasifikasi_produk_id', 'ASC')
            ->get();
        return view('inventori::lap_kartu_stock_rekap_stock', compact('data'));
    }

    public function select_bb_rekap()
    {
        $bb2 = DB::table('m_klasifikasi_produk')
            ->orderBy('m_klasifikasi_produk_id', 'asc')
            ->get();
        $data = array();
        foreach ($bb as $val) {
            $data[$val->m_klasifikasi_produk_id] = [$val->m_klasifikasi_produk_nama];
            $data['all'] = 'All Klasifikasi Produk';
        }
        return response()->json($data);
    }

    public function select_gudang_rekap(Request $request)
    {
        $gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $request->waroeng)
            ->orderBy('m_gudang_id', 'asc')
            ->get();
        $data = array();
        foreach ($gudang as $val) {
            $data[$val->m_gudang_code] = [$val->m_gudang_nama];
            $data['all'] = 'Gudang Utama dan Produksi';
        }
        return response()->json($data);
    }

    public function tampil_rekap(Request $request)
    {
        $master_stok2 = DB::table('m_stok')
                ->join('m_klasifikasi_produk', 'm_klasifikasi_produk_id', 'm_stok_m_klasifikasi_produk_id')
                ->join('m_gudang', 'm_gudang_code', 'm_stok_gudang_code')
                ->selectRaw('m_stok_produk_nama, SUM(m_stok_awal) as stok_awal, SUM(m_stok_masuk) as masuk, SUM(m_stok_keluar) as keluar, SUM(m_stok_saldo) as saldo, m_stok_hpp, m_stok_satuan, m_klasifikasi_produk_nama, m_gudang_nama');
                if($request->gudang != 'all'){
                    $master_stok2->where('m_stok_gudang_code', $request->gudang);
                    if($request->bb != 'all'){
                        $master_stok2->where('m_stok_m_klasifikasi_produk_id', $request->bb);
                    } else {
                        $master_stok2->whereIn('m_stok_m_klasifikasi_produk_id', [1,2,3]);
                    }
                } else {
                    $master_stok2->whereIn('m_stok_gudang_code',  [60001, 60002]);
                    if($request->bb != 'all'){
                        $master_stok2->where('m_stok_m_klasifikasi_produk_id', $request->bb);
                    } else {
                        $master_stok2->whereIn('m_stok_m_klasifikasi_produk_id', [1,2,3]);
                    }
                }
                
        $master_stok = $master_stok2->groupby('m_stok_produk_nama', 'm_stok_hpp', 'm_stok_satuan', 'm_klasifikasi_produk_nama', 'm_gudang_nama')->orderby('m_gudang_nama', 'ASC')->orderby('m_klasifikasi_produk_nama', 'ASC')->orderby('m_stok_produk_nama', 'ASC')->get();

        $data = array();
        foreach ($master_stok as $key => $value) {
            $row = array();
            $row[] = $value->m_gudang_nama;
            $row[] = $value->m_klasifikasi_produk_nama;
            $row[] = $value->m_stok_produk_nama;
            $row[] = number_format($value->stok_awal);
            $row[] = number_format($value->masuk ?? 0);
            $row[] = number_format($value->keluar ?? 0);
            $row[] = number_format($value->saldo ?? 0);
            $row[] = $value->m_stok_satuan;
            $row[] = number_format($value->m_stok_hpp, 0);
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
}
