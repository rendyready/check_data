<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
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
        $data->tanggal = DB::table('rekap_transaksi')
            ->select('r_t_tanggal')
            ->orderBy('r_t_tanggal', 'asc')
            ->get();
        return view('dashboard::rekap_menu', compact('data'));
    }

    public function tanggal_rekap(Request $request)
    {
        $tanggal = DB::table('rekap_transaksi')
            ->select('r_t_tanggal');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $tanggal->whereBetween('r_t_tanggal', $dates);
        } else {
            $tanggal->where('r_t_tanggal', $request->tanggal);
        }
        $tanggal = $tanggal->orderBy('r_t_tanggal', 'asc')
            ->groupby('r_t_tanggal')
            ->get();

        $data = [];
        foreach ($tanggal as $val) {
            $data[] = $val->r_t_tanggal;
        }
        return response()->json($data);
    }

    public function select_waroeng(Request $request)
    {
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code');
        if ($request->id_area != 'all') {
            $waroeng->where('m_w_m_area_id', $request->id_area);
        }
        $waroeng = $waroeng->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
            $data['all'] = ['all waroeng'];
        }
        return response()->json($data);
    }

    public function select_trans(Request $request)
    {
        $trans = DB::table('m_transaksi_tipe')
            ->join('rekap_transaksi', 'r_t_m_t_t_id', 'm_t_t_id')
            ->select('m_t_t_id', 'm_t_t_name');
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            if ($request->id_waroeng != 'all') {
                $trans->where('r_t_m_w_id', $request->id_waroeng);
            }
        } else {
            if ($request->id_waroeng != 'all') {
                $trans->where('r_t_m_w_id', Auth::user()->waroeng_id);
            }
        }
        $trans = $trans->orderBy('m_t_t_id', 'asc')
            ->get();

        $data = array();
        foreach ($trans as $val) {
            $data['all'] = ['all transaksi'];
            $data[$val->m_t_t_name] = [$val->m_t_t_name];
        }
        return response()->json($data);

    }

    public function show(Request $request)
    {
        $tanggal1 = DB::table('rekap_transaksi')
            ->select('r_t_tanggal')
            ->orderBy('r_t_tanggal', 'asc')
            ->groupby('r_t_tanggal');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $tanggal1->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $tanggal1->where('r_t_tanggal', $request->tanggal);
        }
        $tanggal = $tanggal1->get();

        $get = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_w', 'm_w_id', 'r_t_m_w_id')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $get->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $get->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $get->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $get->where('r_t_m_w_id', $request->waroeng);
                if ($request->trans != 'all') {
                    $get->where('m_t_t_name', $request->trans);
                }
            }
        }

        $get2 = $get->selectRaw('sum(r_t_detail_qty) as qty, r_t_detail_reguler_price, r_t_tanggal, r_t_detail_m_produk_nama, m_w_nama, m_jenis_produk_id, m_jenis_produk_nama, m_t_t_name')
            ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'm_w_nama', 'r_t_detail_reguler_price', 'm_jenis_produk_nama', 'm_jenis_produk_id', 'm_t_t_name')
            ->orderby('m_jenis_produk_id', 'ASC')
            ->orderby('r_t_detail_m_produk_nama', 'ASC')
            ->get();
        $data = [];
        foreach ($get2 as $key => $val_menu) {
            $waroeng = $val_menu->m_w_nama;
            $menu = $val_menu->r_t_detail_m_produk_nama;
            $date = $val_menu->r_t_tanggal;
            $qty = $val_menu->qty;
            $nominal = number_format($val_menu->r_t_detail_reguler_price * $qty);
            $kategori = $val_menu->m_jenis_produk_nama;
            $transaksi = $val_menu->m_t_t_name;
            if (!isset($data[$waroeng])) {
                $data[$waroeng] = [];
            }
            if (!isset($data[$waroeng][$transaksi])) {
                $data[$waroeng][$transaksi] = [];
            }
            if (!isset($data[$waroeng][$transaksi][$kategori])) {
                $data[$waroeng][$transaksi][$kategori] = [];
            }
            if (!isset($data[$waroeng][$transaksi][$kategori][$menu])) {
                $data[$waroeng][$transaksi][$kategori][$menu] = [];
            }
            if (!isset($data[$waroeng][$transaksi][$kategori][$menu][$date])) {
                $data[$waroeng][$transaksi][$kategori][$menu][$date] = [
                    'qty' => 0,
                    'nominal' => 0,
                ];
            }
            $data[$waroeng][$transaksi][$kategori][$menu][$date]['qty'] += $qty;
            $data[$waroeng][$transaksi][$kategori][$menu][$date]['nominal'] = $nominal;
        }
        $output = ['data' => []];

        foreach ($data as $waroeng => $kategoris) {
            foreach ($kategoris as $transaksi => $transaksis) {
                foreach ($transaksis as $kategori => $menus) {
                    foreach ($menus as $menu => $dates) {
                        $row = [
                            $waroeng,
                            $transaksi,
                            $kategori,
                            $menu,
                        ];
                        foreach ($tanggal as $date) {
                            $date_str = $date->r_t_tanggal;
                            if (isset($dates[$date_str])) {
                                $row[] = $dates[$date_str]['qty'];
                                $row[] = $dates[$date_str]['nominal'];
                            } else {
                                $row[] = 0;
                                $row[] = 0;
                            }
                        }
                        $output['data'][] = $row;
                    }
                }
            }
        }

        return response()->json($output);
    }

    // public function rekapNonMenu($d, $date)
    // {
    //    $typeTransaksi = DB::table('m_transaksi_tipe')->get();
    //    $sesi = DB::table('rekap_modal')
    //            ->join('users','users_id','=','rekap_modal_created_by')
    //            ->whereRaw("to_char(rekap_modal_tanggal,'YYYY-MM-DD') = '{$date}'")

    //             ->get();
    //    $getMenu = DB::table('m_produk')
    //            ->select('m_produk_id')
    //            ->whereNotIn('m_produk_m_jenis_produk_id',[9,11,12,13])->get();
    //    $listMenu = [];
    //    foreach ($getMenu as $key => $valMenu) {
    //        array_push($listMenu,$valMenu->m_produk_id);
    //    }
    //    $getNonMenu = DB::table('m_produk')
    //            ->select('m_produk_id')
    //            ->whereIn('m_produk_m_jenis_produk_id',[9])->get();
    //    $listNonMenu = [];
    //    foreach ($getNonMenu as $key => $valMenu) {
    //        array_push($listNonMenu,$valMenu->m_produk_id);
    //    }
    //    $getKbd = DB::table('m_produk')
    //            ->select('m_produk_id')
    //            ->whereIn('m_produk_m_jenis_produk_id',[11])->get();
    //    $listKbd = [];
    //    foreach ($getKbd as $key => $valMenu) {
    //        array_push($listKbd,$valMenu->m_produk_id);
    //    }

    //    $getIceCream = DB::table('m_produk')
    //            ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
    //            ->select('m_produk_id')
    //            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[20,22,23,24,25])->get();
    //    $listIceCream = [];
    //    foreach ($getIceCream as $key => $valMenu) {
    //        array_push($listIceCream,$valMenu->m_produk_id);
    //    }
    //    // return $listIceCream;
    //    $sales = [];
    //    foreach ($sesi as $key => $valSesi) {
    //        foreach ($typeTransaksi as $key => $valType) {
    //            $sales[$valSesi->name][$valType->m_t_t_id]['Tipe'] = $valType->m_t_t_name;
    //            $sales[$valSesi->name][$valType->m_t_t_id]['Menu'] = 0;
    //            $sales[$valSesi->name][$valType->m_t_t_id]['Non Menu'] = 0;
    //            $sales[$valSesi->name][$valType->m_t_t_id]['Ice Cream'] = 0;
    //            $sales[$valSesi->name][$valType->m_t_t_id]['KBD'] = 0;
    //            #Menu
    //            $menu = DB::table('rekap_transaksi')
    //                    ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                    ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
    //                    ->where([
    //                        'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                        'r_t_m_t_t_id' => $valType->m_t_t_id
    //                    ])
    //                    ->whereIn('r_t_detail_m_produk_id',$listMenu)
    //                    ->groupBy('r_t_rekap_modal_id')
    //                    ->first();
    //            if (!empty($menu)) {
    //                $sales[$valSesi->name][$valType->m_t_t_id]['Menu'] = number_format($menu->nominal);
    //            }

    //            #Non-Menu
    //            $nonMenu = DB::table('rekap_transaksi')
    //                    ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                    ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
    //                    ->where([
    //                        'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                        'r_t_m_t_t_id' => $valType->m_t_t_id
    //                    ])
    //                    ->whereIn('r_t_detail_m_produk_id',$listNonMenu)
    //                    ->groupBy('r_t_rekap_modal_id')
    //                    ->first();
    //            if (!empty($nonMenu)) {
    //                $sales[$valSesi->name][$valType->m_t_t_id]['Non Menu'] = number_format($nonMenu->nominal);
    //            }

    //            #Ice-Cream
    //            $iceCream = DB::table('rekap_transaksi')
    //                    ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                    ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
    //                    ->where([
    //                        'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                        'r_t_m_t_t_id' => $valType->m_t_t_id
    //                    ])
    //                    ->whereIn('r_t_detail_m_produk_id',$listIceCream)
    //                    ->groupBy('r_t_rekap_modal_id')
    //                    ->first();
    //            if (!empty($iceCream)) {
    //                $sales[$valSesi->name][$valType->m_t_t_id]['Ice Cream'] = number_format($iceCream->nominal);
    //            }

    //            #KBD
    //            $kbd = DB::table('rekap_transaksi')
    //                    ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                    ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
    //                    ->where([
    //                        'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                        'r_t_m_t_t_id' => $valType->m_t_t_id
    //                    ])
    //                    ->whereIn('r_t_detail_m_produk_id',$listKbd)
    //                    ->groupBy('r_t_rekap_modal_id')
    //                    ->first();
    //            if (!empty($kbd)) {
    //                $sales[$valSesi->name][$valType->m_t_t_id]['KBD'] = number_format($kbd->nominal);
    //            }
    //        }
    //    }

    //    $tanggal = Carbon::parse($date)->format('d M Y');
    //    $data = [
    //        'title' => 'Laporan Menu non Menu',
    //        'sales' => $sales,
    //        'tanggal' => $tanggal,
    //        'tglCetak' => Carbon::now()->format('Y-m-d H:i:s')
    //    ];
    //    return view('dashboard::lap_non_menu', $data);
    // }

}
