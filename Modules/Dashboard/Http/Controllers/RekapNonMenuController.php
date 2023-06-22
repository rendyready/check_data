<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RekapNonMenuExcel;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapNonMenuExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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
               ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
               if($request->area != 'all'){
                    $sesi->where('rekap_modal_m_area_id', $request->area);
                    if($request->waroeng != 'all') {
                        $sesi->where('rekap_modal_m_w_id', $request->waroeng);
                    }
                }
               $sesi = $sesi->where('rekap_modal_status', 'close')
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
               ->whereIn('m_produk_m_jenis_produk_id',[9,11])->get();
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

       $getWbdFrozen = DB::table('m_produk')
                ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
                ->select('m_produk_id')
                ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[45])->get();
       $listWbdFrozen = [];
       foreach ($getWbdFrozen as $key => $valMenu) {
           array_push($listWbdFrozen,$valMenu->m_produk_id);
       }

       $getKerupuk = DB::table('m_produk')
            ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[47])->get();
        $listKerupuk = [];
        foreach ($getKerupuk as $key => $valMenu) {
            array_push($listKerupuk,$valMenu->m_produk_id);
        }
       $getMineral = DB::table('m_produk')
            ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[12])->get();
        $listMineral = [];
        foreach ($getMineral as $key => $valMenu) {
            array_push($listMineral,$valMenu->m_produk_id);
        }

       $data = [];
       foreach ($sesi as $key => $valSesi) {
            foreach ($typeTransaksi as $key => $valType) {
               #Menu
                $menu_tot = 0;
                $nota_menu = 0;
                $non_menu = 0;
                $ice_cream = 0;
                $wbd_bumbu = 0;
                $wbd_bumbu_grab = 0;
                $grab_nota = 0;
                $wbd_frozen = 0;
                $wbd_frozen_grab = 0;
                $kerupuk_tot = 0;
                $mineral_tot = 0;
                $pajak_tot = 0;

                $menu = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id',$listMenu)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                        
                $menu_nota = DB::table('rekap_transaksi')
                        ->selectRaw('count(r_t_id) nota')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])->first();

                        if (!empty($menu)) {
                            $menu_tot = $menu->nominal;
                            $nota_menu = $menu_nota->nota;
                        }
                
                
                        
                // if (!empty($nota_menu)) {
                //     $nota_menu = $menu_nota->nota;
                // }
            
               #Non-Menu
               $nonMenu = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, r_t_m_t_t_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id', $listNonMenu)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();

                
               if (!empty($nonMenu)) {
                   $non_menu = $nonMenu->nominal;
               }
         
               #Ice-Cream
               $iceCream = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                        //    'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listIceCream)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
                
               if (!empty($iceCream)) {
                   $ice_cream = $iceCream->nominal;
               }

               #Wbd-Bumbu
               $wbdBumbu = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listKbd)
                       ->whereNotIn('r_t_detail_m_produk_id',$listWbdFrozen)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
                

               if (!empty($wbdBumbu)) {
                   $wbd_bumbu = $wbdBumbu->nominal;
               }
           
               #Wbd-BumbuGrab
               $wbdBumbuGrab = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal, r_t_m_t_t_id')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => 5
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listKbd)
                       ->whereNotIn('r_t_detail_m_produk_id',$listWbdFrozen)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();
                $menu_grab = DB::table('rekap_transaksi')
                        ->selectRaw('count(r_t_id) nota')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => 5
                        ])->first();
                
                if (!empty($wbdBumbuGrab) && !empty($menu_grab) && $wbdBumbuGrab->r_t_m_t_t_id == 5) {
                    $wbd_bumbu_grab = $wbdBumbuGrab->nominal;
                    $grab_nota = $menu_grab->nota;
                }
                 
               #Wbd-Frozen
               $wbdFrozen = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, r_t_m_t_t_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listWbdFrozen)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();
                
               if (!empty($wbdFrozen)) {
                   $wbd_frozen = $wbdFrozen->nominal;
               }
               
               #Wbd-FrozenGrab
               $wbdFrozenGrab = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal, r_t_m_t_t_id')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => 5
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listWbdFrozen)
                       ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
                       ->first();
                
                if (!empty($wbdFrozenGrab)) {
                    $wbd_frozen_grab = $wbdFrozenGrab->nominal;
               }

               #Kerupuk
               $kerupuk = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                        ])
                        ->whereIn('r_t_detail_m_produk_id',$listKerupuk)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                
               if (!empty($kerupuk)) {
                   $kerupuk_tot = $kerupuk->nominal;
               }

               #mineral
               $mineral = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listMineral)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
               
               if (!empty($mineral)) {
                   $mineral_tot = $mineral->nominal;
               }  

               #pajak
               $pajak = DB::table('rekap_transaksi')
                       ->selectRaw('r_t_rekap_modal_id, SUM(r_t_nominal_pajak) pajak')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                       ])
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
                
               if (!empty($pajak)) {
                   $pajak_tot = $pajak->pajak;
               }           
               
                $data[$valSesi->rekap_modal_sesi]['area'] = $valSesi->rekap_modal_m_area_nama;
                $data[$valSesi->rekap_modal_sesi]['waroeng'] = $valSesi->rekap_modal_m_w_nama;
                $data[$valSesi->rekap_modal_sesi]['tanggal'] = date('d-m-Y', strtotime($valSesi->rekap_modal_tanggal));
                $data[$valSesi->rekap_modal_sesi]['sesi'] = $valSesi->rekap_modal_sesi;
                $data[$valSesi->rekap_modal_sesi]['operator'] = $valSesi->name;

                if(in_array($valType->m_t_t_name, ['dine in', 'take away', 'grab', 'gojek', 'shopeefood'])){
                    $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'menu'] = number_format($menu_tot);
                    $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'non_menu'] = number_format($non_menu);
                    $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'nota_menu'] = number_format($nota_menu);
                } 
            }
                    $data[$valSesi->rekap_modal_sesi]['wbd_bb'] = number_format($wbd_bumbu_grab);
                    $data[$valSesi->rekap_modal_sesi]['wbd_frozen'] = number_format($wbd_frozen_grab);
                    $data[$valSesi->rekap_modal_sesi]['nota_grab'] = number_format($grab_nota);

                    $data[$valSesi->rekap_modal_sesi]['ice_cream'] = number_format($ice_cream);
                    $data[$valSesi->rekap_modal_sesi]['air_mineral'] = number_format($mineral_tot);
                    $data[$valSesi->rekap_modal_sesi]['Kerupuk'] = number_format($kerupuk_tot);
                    $data[$valSesi->rekap_modal_sesi]['WBD BB'] = number_format($wbd_bumbu);
                    $data[$valSesi->rekap_modal_sesi]['WBD Frozen'] = number_format($wbd_frozen);
                    $data[$valSesi->rekap_modal_sesi]['Pajak'] = number_format($pajak_tot);
        }
            $convert = [];
            foreach ($data as $row) {
                $convert[] = array_values($row);
            }
           
            $output = array("data" => $convert);
            return response()->json($output);
    }

    public function rekap_non_menu(Request $request)
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
    //    return $listMenu;
       $sales = [];
       foreach ($sesi as $key => $valSesi) {
           foreach ($typeTransaksi as $key => $valType) {
               $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Tipe'] = $valType->m_t_t_name;
               $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Menu'] = 0;
               $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Non Menu'] = 0;
               $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Ice Cream'] = 0;
               $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['KBD'] = 0;
               #Menu
               $menu = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listMenu)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
               if (!empty($menu)) {
                   $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Menu'] = number_format($menu->nominal);
               }

               #Non-Menu
               $nonMenu = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listNonMenu)
                       ->whereNotIn('r_t_detail_m_produk_id',$listKbd)
                       ->whereNotIn('r_t_detail_m_produk_id',$listIceCream)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
               if (!empty($nonMenu)) {
                   $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Non Menu'] = number_format($nonMenu->nominal);
               }

               #Ice-Cream
               $iceCream = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listIceCream)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
               if (!empty($iceCream)) {
                   $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Ice Cream'] = number_format($iceCream->nominal);
               }

               #KBD
               $kbd = DB::table('rekap_transaksi')
                       ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                       ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                       ->where([
                           'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                           'r_t_m_t_t_id' => $valType->m_t_t_id
                       ])
                       ->whereIn('r_t_detail_m_produk_id',$listKbd)
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
               if (!empty($kbd)) {
                   $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['KBD'] = number_format($kbd->nominal);
               }
           }
       }

       $tanggal = Carbon::parse($request->tanggal)->format('d M Y');
       $data = [
           'title' => 'Laporan Menu non Menu',
           'sales' => $sales,
           'tanggal' => $tanggal,
           'tglCetak' => Carbon::now()->format('Y-m-d H:i:s')
       ];
    //    return $sales;
       $pdf = pdf::loadview('dashboard::lap_non_menu', $data)->setPaper('a4');
       return $pdf->download('lap_non_menu_'.tgl_indo($request->tanggal).'.pdf');
    }

    // public function show22(Request $request)
    // {
    //    $typeTransaksi = DB::table('m_transaksi_tipe')->get();
    //    $sesi = DB::table('rekap_modal')
    //            ->join('users','users_id','=','rekap_modal_created_by')
    //            ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
    //            if($request->area != 'all'){
    //                 $sesi->where('rekap_modal_m_area_id', $request->area);
    //                 if($request->waroeng != 'all') {
    //                     $sesi->where('rekap_modal_m_w_id', $request->waroeng);
    //                 }
    //             }
    //            $sesi = $sesi->where('rekap_modal_status', 'close')
    //            ->orderBy('rekap_modal_sesi','asc')
    //            ->get();

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

    //    $getWbdFrozen = DB::table('m_produk')
    //             ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
    //             ->select('m_produk_id')
    //             ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[45])->get();
    //    $listWbdFrozen = [];
    //    foreach ($getWbdFrozen as $key => $valMenu) {
    //        array_push($listWbdFrozen,$valMenu->m_produk_id);
    //    }

    //    $getKerupuk = DB::table('m_produk')
    //         ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
    //         ->select('m_produk_id')
    //         ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[47])->get();
    //     $listKerupuk = [];
    //     foreach ($getKerupuk as $key => $valMenu) {
    //         array_push($listKerupuk,$valMenu->m_produk_id);
    //     }
    //     // return $listKerupuk;
    //    $getMineral = DB::table('m_produk')
    //         ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
    //         ->select('m_produk_id')
    //         ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[12])->get();
    //     $listMineral = [];
    //     foreach ($getMineral as $key => $valMenu) {
    //         array_push($listMineral,$valMenu->m_produk_id);
    //     }

    //     $data = [];
    //     $menu_tot = 0;
    //     $non_menu = 0;
    //     $ice_cream = 0;
    //     $wbd_bumbu_grab = 0;
    //     $wbd_frozen = 0;
    //     $wbd_frozen_grab = 0;
    //     $kerupuk_tot = 0;
    //     $mineral_tot = 0;
    //     $pajak_tot = 0;
    //     $nota_menu = 0;
    //     $wbd_bumbu = 0;
    //     $grab_nota = 0;
    //    foreach ($sesi as $key => $valSesi) {
    //         foreach ($typeTransaksi as $typeKey => $valType) {
    //            #nominal                       
    //            $query = DB::table('rekap_transaksi')
    //                     ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                     ->selectRaw('r_t_rekap_modal_id, r_t_m_t_t_id,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listMenu).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as menu_total,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listNonMenu).') AND r_t_detail_m_produk_id NOT IN ('.implode(',', $listKbd).')  AND r_t_detail_m_produk_id NOT IN ('.implode(',', $listIceCream).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as non_menu_total')
    //                     ->where([
    //                         'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                         'r_t_m_t_t_id' => $valType->m_t_t_id
    //                     ])
    //                     ->groupby('r_t_rekap_modal_id', 'r_t_m_t_t_id')
    //                     ->first();
                        
    //             $query_no_method = DB::table('rekap_transaksi')
    //                     ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                     ->selectRaw('r_t_rekap_modal_id, 
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listIceCream).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as ice_cream,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listKbd).') AND r_t_detail_m_produk_id NOT IN ('.implode(',', $listWbdFrozen).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as wbd_bb,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listWbdFrozen).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as wbd_frozen,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listKerupuk).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as kerupuk,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listMineral).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as mineral')
    //                     ->where([
    //                         'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                     ])
    //                     ->groupby('r_t_rekap_modal_id')
    //                     ->first();
                
    //             $grab = DB::table('rekap_transaksi')
    //                     ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
    //                     ->selectRaw('r_t_rekap_modal_id, r_t_m_t_t_id,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listWbdFrozen).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as grab_frozen,
    //                     sum(CASE WHEN r_t_detail_m_produk_id IN ('.implode(',', $listKbd).') AND r_t_detail_m_produk_id NOT IN ('.implode(',', $listWbdFrozen).') THEN r_t_detail_reguler_price * r_t_detail_qty ELSE 0 END) as grab_bb')
    //                     ->where([
    //                         'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                         'r_t_m_t_t_id' => 5
    //                     ])
    //                     ->groupby('r_t_rekap_modal_id', 'r_t_m_t_t_id')
    //                     ->first();

    //             #Nota      
    //             $menu_nota = DB::table('rekap_transaksi')
    //                     ->selectRaw('count(r_t_id) nota')
    //                     ->where([
    //                         'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                         'r_t_m_t_t_id' => $valType->m_t_t_id
    //                     ])->first();
    //             $menu_grab = DB::table('rekap_transaksi')
    //                     ->selectRaw('count(r_t_id) nota')
    //                     ->where([
    //                         'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                         'r_t_m_t_t_id' => 5
    //                     ])->first();

    //             #pajak-Query
    //            $pajak = DB::table('rekap_transaksi')
    //                     ->selectRaw('r_t_rekap_modal_id, SUM(r_t_nominal_pajak) pajak')
    //                     ->where([
    //                         'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
    //                     ])
    //                     ->groupBy('r_t_rekap_modal_id')
    //                     ->first();

    //             #Menu
    //            if (!empty($query->menu_total)) {
    //                $menu_tot = $query->menu_total;
    //                $nota_menu = $menu_nota->nota;
    //            }

    //            #Non-Menu
    //            if (!empty($query->non_menu_total)) {
    //                 $non_menu = $query->non_menu_total;
    //             }
                
    //             #Ice-Cream
    //            if (!empty($query_no_method->ice_cream)) {
    //                $ice_cream = $query_no_method->ice_cream;
    //            }

    //            #Wbd-BB
    //            if (!empty($query_no_method->ice_cream)) {
    //                 $wbd_bumbu = $query_no_method->wbd_bb;
    //             }

    //             #Wbd-Frozen
    //            if (!empty($query_no_method->wbd_frozen)) {
    //                 $wbd_frozen = $query_no_method->wbd_frozen;
    //             }
                
    //             #Wbd-BB-Grab
    //             if (!empty($grab->grab_bb) && !empty($menu_grab) && $grab->r_t_m_t_t_id == 5) {
    //                 $wbd_bumbu_grab = $grab->grab_bb;
    //                 $grab_nota = $menu_grab->nota;
    //             }
                 
    //            #Wbd-Frozen-Grab
    //            if (!empty($grab->grab_frozen) && $grab->r_t_m_t_t_id == 5) {
    //                $wbd_frozen_grab = $grab->grab_frozen;
    //            }

    //            #Kerupuk
    //            if (!empty($query_no_method->kerupuk)) {
    //                $kerupuk_tot = $query_no_method->kerupuk;
    //            }

    //            #mineral
    //            if (!empty($query_no_method->mineral)) {
    //                $mineral_tot = $query_no_method->mineral;
    //            }  
                
    //            #Pajak
    //            if (!empty($pajak)) {
    //                $pajak_tot = $pajak->pajak;
    //            }           
               
    //             $data[$valSesi->rekap_modal_sesi]['area'] = $valSesi->rekap_modal_m_area_nama;
    //             $data[$valSesi->rekap_modal_sesi]['waroeng'] = $valSesi->rekap_modal_m_w_nama;
    //             $data[$valSesi->rekap_modal_sesi]['tanggal'] = date('d-m-Y', strtotime($valSesi->rekap_modal_tanggal));
    //             $data[$valSesi->rekap_modal_sesi]['sesi'] = $valSesi->rekap_modal_sesi;
    //             $data[$valSesi->rekap_modal_sesi]['operator'] = $valSesi->name;

    //             if(in_array($valType->m_t_t_id, [1,2,3,4,6])){
    //                 $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'menu'] = number_format($menu_tot);
    //                 $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'non_menu'] = number_format($non_menu);
    //                 $data[$valSesi->rekap_modal_sesi][$valType->m_t_t_id.'-'.'nota_menu'] = number_format($nota_menu);
    //             } 
    //         }
    //                 $data[$valSesi->rekap_modal_sesi]['wbd_bb'] = number_format($wbd_bumbu_grab);
    //                 $data[$valSesi->rekap_modal_sesi]['wbd_frozen'] = number_format($wbd_frozen_grab);
    //                 $data[$valSesi->rekap_modal_sesi]['nota_grab'] = number_format($grab_nota);

    //                 $data[$valSesi->rekap_modal_sesi]['ice_cream'] = number_format($ice_cream);
    //                 $data[$valSesi->rekap_modal_sesi]['air_mineral'] = number_format($mineral_tot);
    //                 $data[$valSesi->rekap_modal_sesi]['Kerupuk'] = number_format($kerupuk_tot);
    //                 $data[$valSesi->rekap_modal_sesi]['WBD BB'] = number_format($wbd_bumbu);
    //                 $data[$valSesi->rekap_modal_sesi]['WBD Frozen'] = number_format($wbd_frozen);
    //                 $data[$valSesi->rekap_modal_sesi]['Pajak'] = number_format($pajak_tot);
    //     }
    //         $convert = [];
    //         foreach ($data as $row) {
    //             $convert[] = array_values($row);
    //         }
           
    //         $output = array("data" => $convert);
    //         return response()->json($data);
    // }
}
