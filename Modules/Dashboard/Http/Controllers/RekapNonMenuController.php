<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class RekapNonMenuController extends Controller
{
    
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
        return view('dashboard::rekap_non_menu', compact('data'));
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
            $data['all'] = ['all waroeng'];
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
       $typeTransaksi = DB::table('m_transaksi_tipe')->get();
       $sesi = DB::table('rekap_modal')
               ->join('users','users_id','=','rekap_modal_created_by')
               ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal)
               ->where('rekap_modal_m_w_id', $request->waroeng)
               ->where('rekap_modal_status', 'close')
               ->orderBy('rekap_modal_sesi','asc')
               ->get();

       $getMenu = DB::table('m_produk')
               ->select('m_produk_id')
               ->whereNotIn('m_produk_m_jenis_produk_id',[9,11,12,13])->get();
       $listMenu = [];
       foreach ($getMenu as $key => $valMenu) {
           array_push($listMenu,$valMenu->m_produk_id);
       }
       $getNonMenu = DB::table('m_produk')
               ->select('m_produk_id')
               ->whereIn('m_produk_m_jenis_produk_id',[9])->get();
       $listNonMenu = [];
       foreach ($getNonMenu as $key => $valMenu) {
           array_push($listNonMenu,$valMenu->m_produk_id);
       }
       $getKbd = DB::table('m_produk')
               ->select('m_produk_id')
               ->whereIn('m_produk_m_jenis_produk_id',[11])->get();
       $listKbd = [];
       foreach ($getKbd as $key => $valMenu) {
           array_push($listKbd,$valMenu->m_produk_id);
       }

       $getIceCream = DB::table('m_produk')
               ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
               ->select('m_produk_id')
               ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[20,22,23,24,25])->get();
       $listIceCream = [];
       foreach ($getIceCream as $key => $valMenu) {
           array_push($listIceCream,$valMenu->m_produk_id);
       }
    //    return $listIceCream;

       $data = [];
    //    $i =1;
       foreach ($sesi as $key => $valSesi) {
           
            $data[$valSesi->rekap_modal_sesi]['area'] = $valSesi->rekap_modal_m_area_nama;
            $data[$valSesi->rekap_modal_sesi]['waroeng'] = $valSesi->rekap_modal_m_w_nama;
            $data[$valSesi->rekap_modal_sesi]['tanggal'] = date('d-m-Y', strtotime($valSesi->rekap_modal_tanggal));
            // $data[$valSesi->rekap_modal_sesi]['tipe'] = $valType->m_t_t_name;
            $data[$valSesi->rekap_modal_sesi]['sesi'] = $valSesi->rekap_modal_sesi;
            $data[$valSesi->rekap_modal_sesi]['operator'] = $valSesi->name;
            
            
            foreach ($typeTransaksi as $key => $valType) {
               
               #Menu
               $menu = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_m_t_t_id, r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal, count(r_t_id) as nota')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listMenu)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();
                $menu_tot = 0;
                $nota_menu = 0;
               if (!empty($menu) && in_array($valType->m_t_t_id, [1, 2, 3, 4, 6, 7]) && $valType->m_t_t_id == $menu->r_t_m_t_t_id) {
                   $menu_tot = $menu->nominal;
                   $nota_menu = $menu->nota;
               }

               #Non-Menu
               $nonMenu = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_m_t_t_id, r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal, count(r_t_id) as nota')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listNonMenu)
                       ->whereNotIn('r_t_detail_m_produk_id',$listKbd)
                       ->whereNotIn('r_t_detail_m_produk_id',$listIceCream)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();
                $non_menu =0;
                $nota_non_menu = 0;
               if (!empty($nonMenu) && in_array($valType->m_t_t_id, [1, 2, 3, 4, 6, 7]) && $valType->m_t_t_id == $nonMenu->r_t_m_t_t_id) {
                   $non_menu = $nonMenu->nominal;
                   $nota_non_menu = $nonMenu->nota;
               }

               #KBD
               $kbd = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_m_t_t_id, r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal, count(r_t_id) as nota')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listKbd)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();
               $wbd = 0;
               $nota_wbd = 0;
               if (!empty($kbd) && $valType->m_t_t_id == 5 && $valType->m_t_t_id == $kbd->r_t_m_t_t_id) {
                   $wbd = $kbd->nominal;
                   $nota_wbd = $kbd->nota;
               }

            //    #Ice-Cream
            //    $iceCream = DB::table('rekap_transaksi')
            //            ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
            //            ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
            //            ->where([
            //                'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
            //                'r_t_m_t_t_id' => $valType->m_t_t_id
            //            ])
            //            ->whereIn('r_t_detail_m_produk_id',$listIceCream)
            //            ->groupBy('r_t_rekap_modal_id')
            //            ->first();
            //    if (!empty($iceCream)) {
            //        $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id]['ice_cream'] = number_format($iceCream->nominal);
            //    }

            if(in_array($valType->m_t_t_id, [1, 2, 3, 4, 6, 7])){
                $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'nota_menu'] = number_format($nota_menu + $nota_non_menu);
                $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'menu'] = number_format($menu_tot);
                $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'non_menu'] = number_format($non_menu);
           } else {
                $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'nota_wbd'] = number_format($wbd);
                $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'wbd'] = number_format($wbd);
           }
           }
       }

    //    $tanggal = Carbon::parse($request->tanggal)->format('d M Y');
    //    $data = [
    //        'title' => 'Laporan Menu non Menu',
    //        'data' => $data,
    //        'tanggal' => $tanggal,
    //        'tglCetak' => Carbon::now()->format('Y-m-d H:i:s')
    //     //    'area' => $area;
    //    ];

            $convert = [];
            foreach ($data as $row) {
                $convert[] = array_values($row);
            }
            // $convert = array();
            // foreach ($data as $row) {
            //     $convert = array_merge_recursive($convert, $row);
            // }
           
            $output = array("data" => $convert);
            return response()->json($output);
    }

    public function show2(Request $request)
    {
       $typeTransaksi = DB::table('m_transaksi_tipe')->get();
       $sesi = DB::table('rekap_modal')
               ->join('users','users_id','=','rekap_modal_created_by')
               ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal)
               ->where('rekap_modal_m_w_id', $request->waroeng)
               ->where('rekap_modal_status', 'close')
               ->orderBy('rekap_modal_sesi','asc')
               ->get();

       $getMenu = DB::table('m_produk')
               ->select('m_produk_id')
               ->whereNotIn('m_produk_m_jenis_produk_id',[9,11,12,13])->get();
       $listMenu = [];
       foreach ($getMenu as $key => $valMenu) {
           array_push($listMenu,$valMenu->m_produk_id);
       }
       $getNonMenu = DB::table('m_produk')
               ->select('m_produk_id')
               ->whereIn('m_produk_m_jenis_produk_id',[9])->get();
       $listNonMenu = [];
       foreach ($getNonMenu as $key => $valMenu) {
           array_push($listNonMenu,$valMenu->m_produk_id);
       }
       $getKbd = DB::table('m_produk')
               ->select('m_produk_id')
               ->whereIn('m_produk_m_jenis_produk_id',[11])->get();
       $listKbd = [];
       foreach ($getKbd as $key => $valMenu) {
           array_push($listKbd,$valMenu->m_produk_id);
       }

       $getIceCream = DB::table('m_produk')
               ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
               ->select('m_produk_id')
               ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[20,22,23,24,25])->get();
       $listIceCream = [];
       foreach ($getIceCream as $key => $valMenu) {
           array_push($listIceCream,$valMenu->m_produk_id);
       }

       $data = [];
        foreach ($sesi as $valSesi) {
            foreach ($typeTransaksi as $valType) {
                $tanggal = date('d-m-Y', strtotime($valSesi->rekap_modal_tanggal));
                $tipe = $valType->m_t_t_name;
                $area = $valSesi->rekap_modal_m_area_nama;
                $waroeng = $valSesi->rekap_modal_m_w_nama;
                $sesi = $valSesi->rekap_modal_sesi;
                $operator = $valSesi->name;

                if (in_array($valType->m_t_t_id, [1, 2, 3, 4, 6, 7])) {
                    $menu = 0;
                    $non_menu = 0;
                } else {
                    $menu = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id', $listMenu)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                    $non_menu = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id', $listNonMenu)
                        ->whereNotIn('r_t_detail_m_produk_id', $listKbd)
                        ->whereNotIn('r_t_detail_m_produk_id', $listIceCream)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                    $menu = $menu ? number_format($menu->nominal) : 0;
                    $non_menu = $non_menu ? number_format($non_menu->nominal) : 0;
                }

                if ($valType->m_t_t_id == 5) {
                    $kbd = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id', $listKbd)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                    $kbd = $kbd ? number_format($kbd->nominal) : 0;
                } else {
                    $kbd = 0;
                }

                if (in_array($valType->m_t_t_id, [1, 2, 3, 4, 6, 7])) {
                    $data[] = [
                        'tanggal' => $tanggal,
                        'tipe' => $tipe,
                        'area' => $area,
                        'waroeng' => $waroeng,
                        'menu' => $menu,
                        'non_menu' => $non_menu,
                    ];
                } else {
                    $data[] = [
                        'tanggal' => $tanggal,
                        'tipe' => $tipe,
                        'area' => $area,
                        'waroeng' => $waroeng,
                        'kbd' => $kbd,
                    ];
                }
            }
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    
}
