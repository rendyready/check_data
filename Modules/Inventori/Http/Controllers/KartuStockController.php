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
        //stok awal master
        $master_stok = DB::table('m_stok')
            ->select('m_stok_awal')
            ->where('m_stok_gudang_code', $request->gudang)
            ->where('m_stok_m_produk_code', $request->bb)
            ->first();

        //stok awal detail
        $stok_awal = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            // ->select(DB::raw('SUM(m_stok_detail_masuk - m_stok_detail_keluar + m_stok_detail_so) as stok_awal'))
            ->select('m_stok_detail_so', 'm_stok_detail_id')
            ->where('m_stok_detail_m_produk_code', $request->bb)
            ->where('m_stok_detail_gudang_code', $request->gudang);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $stok_awal->where('m_stok_detail_tgl', '<', $start);
            } else {
                $stok_awal->where('m_stok_detail_tgl', '<', $request->tanggal);
            }
            $stok_awal = $stok_awal->first();

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

        $i = 0;    
        $a = 0;
        $stokkeluar = 0;   
        $previousSoDate = null; 
        $data = array();
        foreach ($stok as $value) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($value->m_stok_detail_tgl));
            $row[] = $value->m_stok_detail_m_produk_nama;
            if (is_null($stok_awal) && $a == 0) {
                $stokawal = $master_stok->m_stok_awal;
                $a = 1;
            } elseif ($stok_awal->m_stok_detail_so != null) {
                $stokawal = $master_stok->m_stok_awal + $stok_awal->m_stok_detail_so;
            }  elseif ($stok_awal->m_stok_detail_so == null) {
                $stokawal = $master_stok->m_stok_awal + $stokkeluar;
            }
            // } elseif (is_null($value->m_stok_detail_so) && is_null($previousSoDate) || $previousSoDate != date('Y-m-d', strtotime($value->m_stok_detail_tgl))) {
            //     $stokawal = $stokkeluar;
            //     $previousSoDate = date('Y-m-d', strtotime('-1 day', strtotime($value->m_stok_detail_tgl)));
            // } elseif (!is_null($value->m_stok_detail_so) && is_null($previousSoDate) || $previousSoDate != date('Y-m-d', strtotime($value->m_stok_detail_tgl))) {
            //     $stokawal = $value->m_stok_detail_so;
            //     $previousSoDate = date('Y-m-d', strtotime('-1 day', strtotime($value->m_stok_detail_tgl)));
            // }
            $row[] = $stokawal;
            $row[] = $value->m_stok_detail_masuk ?? 0;
            $row[] = $value->m_stok_detail_keluar ?? 0;
            if($i == 0){
                $stokkeluar = $stokawal + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar;
                $row[] = $stokkeluar;
                $i = 1;
            } else {
                $row[] = $stokkeluar + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar;
                $stokkeluar = $stokkeluar + $value->m_stok_detail_masuk - $value->m_stok_detail_keluar;
            }
            $row[] = $value->m_stok_detail_so ?? 0;
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

    public function select_gudang_rekap(Request $request)
    {
        $gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', $request->waroeng)
            ->orderBy('m_gudang_id', 'asc')
            ->get();
        $data = array();
        foreach ($gudang as $val) {
            $data[$val->m_gudang_code] = [$val->m_gudang_nama];
            // $data['all'] = 'Gudang Utama dan Produksi';
        }
        return response()->json($data);
    }

    public function tampil_rekap(Request $request)
    {
    $stok = DB::table('m_stok_detail')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->join('m_produk', 'm_produk_code', 'm_stok_detail_m_produk_code')
            ->join('m_klasifikasi_produk', 'm_klasifikasi_produk_id', 'm_produk_m_klasifikasi_produk_id')
            ->selectRaw('m_stok_detail_m_produk_nama, SUM(m_stok_detail_masuk) as masuk, SUM(m_stok_detail_keluar) as keluar, sum(m_stok_detail_so) as opname, avg(m_stok_detail_hpp) hpp, m_gudang_nama, m_stok_detail_satuan, m_gudang_code, m_klasifikasi_produk_nama')
            ->where('m_gudang_code', $request->gudang);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $stok->whereBetween('m_stok_detail_tgl', [$start, $end]);
            } else {
                $stok->where('m_stok_detail_tgl', $request->tanggal);
            }     
            if($request->bb != 'all'){
                $stok->where('m_klasifikasi_produk_id', $request->bb);
            } else {
                $stok->whereIn('m_klasifikasi_produk_id', [1,2,3]);
            }
            $stok_utama = $stok->where('m_area_id', $request->area)
            ->where('m_gudang_m_w_id', $request->waroeng)
            // ->where('m_stok_detail_created_at', $request->waroeng)
            ->groupby('m_stok_detail_m_produk_nama', 'm_gudang_nama', 'm_stok_detail_satuan', 'm_gudang_code', 'm_klasifikasi_produk_nama')
            ->orderby('m_gudang_code', 'DESC')
            ->orderby('m_stok_detail_m_produk_nama', 'ASC')
            ->get();

    $master_stok = DB::table('m_stok')
            ->join('m_gudang', 'm_gudang_code', 'm_stok_gudang_code')
            ->join('m_stok_detail', 'm_stok_detail_m_produk_code', 'm_stok_m_produk_code')
            ->where('m_gudang_code', $request->gudang);
            $master_stok = $master_stok->where('m_gudang_m_w_id', $request->waroeng)
            ->get();

            $data = array();
            foreach ($stok_utama as $stock) {
                $stok_awal = DB::table('m_stok_detail')
                    ->join('m_gudang', 'm_gudang_code', 'm_stok_detail_gudang_code')
                    ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
                    ->join('m_area', 'm_area_id', 'm_w_m_area_id')
                    ->selectRaw('m_stok_detail_m_produk_nama, SUM(m_stok_detail_masuk) as masuk, m_gudang_code, sum(m_stok_detail_so) as opname')
                    ->where('m_gudang_code', $request->gudang);
                    if (strpos($request->tanggal, 'to') !== false) {
                        [$start, $end] = explode('to', $request->tanggal);
                        $stok_awal->where('m_stok_detail_tgl', '<', $start);
                    } else {
                        $stok_awal->where('m_stok_detail_tgl', '<', $request->tanggal);
                    }     
                    $sAwal = $stok_awal->where('m_area_id', $request->area)
                    ->where('m_gudang_m_w_id', $request->waroeng)
                    ->groupby('m_stok_detail_m_produk_nama', 'm_gudang_code', 'm_stok_detail_m_produk_nama')
                    ->orderby('m_gudang_code', 'DESC')
                    ->orderby('m_stok_detail_m_produk_nama', 'ASC')
                    ->first();

                $i = 0;
                $first_stok = 0;
                $stokkeluar = 0;
                foreach ($master_stok as $mStok) {
                    if ($stock->m_stok_detail_m_produk_nama == $mStok->m_stok_produk_nama && $stock->m_gudang_code == $mStok->m_gudang_code) {     
                        $first_stok = $mStok->m_stok_awal;
                        if (!is_null($sAwal)) {
                            if ($stock->m_stok_detail_m_produk_nama == $sAwal->m_stok_detail_m_produk_nama && $stock->m_gudang_code == $sAwal->m_gudang_code) {
                                if ($sAwal->opname != null){
                                    $first_stok = $mStok->m_stok_awal + $sAwal->masuk + $sAwal->opname;
                                } elseif ($sAwal->opname == null) {
                                    $first_stok = $mStok->m_stok_awal + $sAwal->masuk + $stokkeluar;
                                }
                            } 
                        } 
                    }
                }
                
                $row = array();
                $row[] = $stock->m_gudang_nama;
                $row[] = $stock->m_klasifikasi_produk_nama;
                $row[] = $stock->m_stok_detail_m_produk_nama;
                $row[] = $first_stok;
                $row[] = $stock->masuk ?? 0;
                $row[] = $stock->keluar ?? 0;
                $stokkeluar = $first_stok + $stock->masuk - $stock->keluar;
                $row[] = $stokkeluar;
                $row[] = $stock->opname ?? 0;
                $row[] = $stock->m_stok_detail_satuan;
                $row[] = number_format($stock->hpp);
                $data[] = $row;
            }
            
            $output = array("data" => $data);
            return response()->json($output);
    }
}
