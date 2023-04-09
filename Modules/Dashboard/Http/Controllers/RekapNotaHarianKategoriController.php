<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;

class RekapNotaHarianKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->payment = DB::table('m_transaksi_tipe')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_nota_harian_kategori', compact('data'));
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

    public function tanggal_rekap(Request $request)
    {
            $tanggal = DB::table('m_transaksi_tipe')
                ->join('rekap_transaksi','r_t_m_t_t_id','=','m_t_t_id')
                ->select('r_t_tanggal', 'm_t_t_id', 'm_t_t_name')
                ->where('r_t_status','paid')
                ->where('r_t_m_w_id', $request->waroeng);
                if (strpos($request->tanggal, 'to') !== false) {
                    $dates = explode('to', $request->tanggal);
                    $tanggal->whereBetween('r_t_tanggal', $dates);
                } else {
                    $tanggal->where('r_t_tanggal', $request->tanggal);
                }
                $tanggal = $tanggal->groupby('r_t_tanggal', 'm_t_t_id', 'm_t_t_name')
                ->orderby('m_t_t_id','asc')
                ->get();
        
        $data = [];
        foreach ($tanggal as $val) {
            $data[] = $val->m_t_t_name;
        }
        return response()->json($data);
    }

    // public function select_user(Request $request)
    // {
    //     $user = DB::table('users')
    //         ->join('rekap_transaksi', 'r_t_created_by', 'users_id')
    //         ->select('users_id', 'name')
    //         ->where('waroeng_id', $request->id_waroeng);
    //         if (strpos($request->tanggal, 'to') !== false) {
    //             [$start, $end] = explode('to' ,$request->tanggal);
    //             $user->whereBetween('r_t_tanggal', [$start, $end]);
    //         } else {
    //             $user->where('r_t_tanggal', $request->tanggal);
    //         }
    //         $user1 = $user->orderBy('users_id', 'asc')
    //         ->get();
    //     $data = array();
    //     foreach ($user1 as $val) {
    //         $data[$val->users_id] = [$val->name];
    //         $data['all'] = 'All Operator';
    //     }
    //     return response()->json($data);
    // }

    public function show(Request $request)
    {
        $salesByMethodPay = DB::table('m_transaksi_tipe')
                    ->selectraw('MAX(m_t_t_name) tipe_name, rekap_modal_id, name,
                        m_t_t_id, m_payment_method_type,
                        r_t_m_w_nama,r_t_m_area_nama,r_t_tanggal,
                        COALESCE(SUM(r_t_nominal_pajak),0) as pajak,
                        COALESCE(SUM(r_t_nominal_total_bayar),0) as tagihan,
                        COALESCE(SUM(r_t_nominal_kembalian),0) as kembalian,
                        COALESCE(SUM(r_p_t_nominal),0) as pay
                    ')
                    ->join('rekap_transaksi','r_t_m_t_t_id','=','m_t_t_id')
                    ->join('rekap_payment_transaksi','r_p_t_r_t_id','=','r_t_id')
                    ->join('m_payment_method','m_payment_method_id','=','r_p_t_m_payment_method_id')
                    ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                    ->join('users', 'users_id', 'rekap_modal_created_by')
                    ->where('r_t_status','paid')
                    ->groupby('m_t_t_id','m_payment_method_type','r_t_m_w_nama','r_t_m_area_nama','r_t_tanggal', 'rekap_modal_id', 'name')
                    ->orderby('m_t_t_id','asc')
                    ->where('r_t_m_w_id', $request->waroeng);
        if (strpos($request->tanggal, 'to') !== false) {   
            $dates = explode('to' ,$request->tanggal);  
            $salesByMethodPay->whereBetween('r_t_tanggal', $dates);
        }else{
            $salesByMethodPay->where('r_t_tanggal', $request->tanggal);
        }

        $salesByMethodPay2 = $salesByMethodPay->get();
          
        $tipeTransaksi = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id','asc')->get();
        $groupPay = ['cash','transfer'];

        $data = [];
        foreach ($tipeTransaksi as $key => $valTrans) {
            foreach ($groupPay as $key => $valGroup) {
                foreach ($salesByMethodPay2 as $key => $valMpay) {
                    $data[$valMpay->rekap_modal_id]['area'] = $valMpay->r_t_m_area_nama;
                    $data[$valMpay->rekap_modal_id]['waroeng'] = $valMpay->r_t_m_w_nama;
                    $data[$valMpay->rekap_modal_id]['operator'] = $valMpay->name;
                    $data[$valMpay->rekap_modal_id]['tanggal'] = $valMpay->r_t_tanggal;
                    if ($valTrans->m_t_t_id == $valMpay->m_t_t_id) {
                        $data[$valMpay->rekap_modal_id][$valTrans->m_t_t_name.'-'.$valGroup] = 0;
                        $data[$valMpay->rekap_modal_id][$valTrans->m_t_t_name.'-'.$valGroup.'-pajak'] = 0;

                        $pay = $valMpay->pay;
                        if ($valMpay->m_payment_method_type == 'cash') {
                            $pay = $valMpay->pay - $valMpay->kembalian;
                        }
                        $data[$valMpay->rekap_modal_id][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type] = number_format($pay);
                        $data[$valMpay->rekap_modal_id][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type.'-pajak'] = number_format($valMpay->pajak);
                    }
                    $length = count($data);
                    $convert = array();
                    for ($i=1; $i <= $length ; $i++) { 
                        array_push($convert,array_values($data[$valMpay->rekap_modal_id]));
                    }  
                }
            }
        }
               
        $output = array("data" => $convert);
        return response()->json($output);
    }

    public function rekap_non_menu(Request $request)
    {
       $typeTransaksi = DB::table('m_transaksi_tipe')->get();
       $sesi = DB::table('rekap_modal')
               ->join('users','users_id','=','rekap_modal_created_by')
               ->whereRaw("to_char(rekap_modal_tanggal,'YYYY-MM-DD') = '{$request->tanggal}'")
               ->where('rekap_modal_m_w_id', $request->waroeng)
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
       // return $listIceCream;
       $sales = [];
       foreach ($sesi as $key => $valSesi) {
           foreach ($typeTransaksi as $key => $valType) {
               $sales[$valSesi->name][$valType->m_t_t_id]['Tipe'] = $valType->m_t_t_name;
               $sales[$valSesi->name][$valType->m_t_t_id]['Menu'] = 0;
               $sales[$valSesi->name][$valType->m_t_t_id]['Non Menu'] = 0;
               $sales[$valSesi->name][$valType->m_t_t_id]['Ice Cream'] = 0;
               $sales[$valSesi->name][$valType->m_t_t_id]['KBD'] = 0;
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
                   $sales[$valSesi->name][$valType->m_t_t_id]['Menu'] = number_format($menu->nominal);
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
                       ->groupBy('r_t_rekap_modal_id')
                       ->first();
               if (!empty($nonMenu)) {
                   $sales[$valSesi->name][$valType->m_t_t_id]['Non Menu'] = number_format($nonMenu->nominal);
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
                   $sales[$valSesi->name][$valType->m_t_t_id]['Ice Cream'] = number_format($iceCream->nominal);
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
                   $sales[$valSesi->name][$valType->m_t_t_id]['KBD'] = number_format($kbd->nominal);
               }
           }
       }

       // foreach ($sales as $key => $value) {
       //     // return $value;
       //     foreach ($value as $key2 => $val2) {
       //         return $val2;
       //         // foreach ($val2 as $key3 => $val3) {
       //         //     return $val2;
       //         // }
       //     }
       // }
       // return response($sales);
       $tanggal = Carbon::parse($request->tanggal)->format('d M Y');
       $data = [
           'title' => 'Laporan Menu non Menu',
           'sales' => $sales,
           'tanggal' => $tanggal,
           'tglCetak' => Carbon::now()->format('Y-m-d H:i:s')
       ];
       return view('dashboard::lap_non_menu', $data);
    }
    
}



    // public function show(Request $request)
    // {
    //     $salesByMethodPay = DB::table('m_transaksi_tipe')
    //                 ->selectraw('MAX(m_t_t_name) name,
    //                     m_t_t_id, m_payment_method_type,
    //                     r_t_m_w_nama,r_t_m_area_nama,r_t_tanggal,
    //                     COALESCE(SUM(r_t_nominal_pajak),0) as pajak,
    //                     COALESCE(SUM(r_t_nominal_total_bayar),0) as tagihan,
    //                     COALESCE(SUM(r_t_nominal_kembalian),0) as kembalian,
    //                     COALESCE(SUM(r_p_t_nominal),0) as pay
    //                 ')
    //                 ->join('rekap_transaksi','r_t_m_t_t_id','=','m_t_t_id')
    //                 ->join('rekap_payment_transaksi','r_p_t_r_t_id','=','r_t_id')
    //                 ->join('m_payment_method','m_payment_method_id','=','r_p_t_m_payment_method_id')
    //                 ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
    //                 ->where('r_t_status','paid')
    //                 ->groupby('m_t_t_id','m_payment_method_type','r_t_m_w_nama','r_t_m_area_nama','r_t_tanggal')
    //                 ->orderby('m_t_t_id','asc')
    //                 ->where('r_t_m_w_id', $request->waroeng);
    //                 // ->where('rekap_modal_sesi', $request->sesi);

    //     if (strpos($request->tanggal, 'to') !== false) {   
    //         $dates = explode('to' ,$request->tanggal);  
    //         $salesByMethodPay->whereBetween('r_t_tanggal', $dates);
    //     }else{
    //         $salesByMethodPay->where('r_t_tanggal', $request->tanggal);
    //     }

    //     $salesByMethodPay2 = $salesByMethodPay->get();
          
    //     $tipeTransaksi = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id','asc')->get();
    //     $groupPay = ['cash','transfer'];

    //     $data = [];
    //     foreach ($tipeTransaksi as $key => $valTrans) {
    //         foreach ($groupPay as $key => $valGroup) {
    //             foreach ($salesByMethodPay2 as $key => $valMpay) {
    //                 $data[$valMpay->r_t_tanggal]['area'] = $valMpay->r_t_m_area_nama;
    //                 $data[$valMpay->r_t_tanggal]['waroeng'] = $valMpay->r_t_m_w_nama;
    //                 // $data[$valMpay->r_t_tanggal]['waroeng'] = $valMpay->rekap_modal_sesi;
    //                 $data[$valMpay->r_t_tanggal]['tanggal'] = $valMpay->r_t_tanggal;
    //                 if ($valTrans->m_t_t_id == $valMpay->m_t_t_id) {
    //                     $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valGroup] = 0;
    //                     $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valGroup.'-pajak'] = 0;

    //                     $pay = $valMpay->pay;
    //                     if ($valMpay->m_payment_method_type == 'cash') {
    //                         $pay = $valMpay->pay - $valMpay->kembalian;
    //                     }
    //                     $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type] = number_format($pay);
    //                     $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type.'-pajak'] = number_format($valMpay->pajak);
    //                 }
    //             }
    //         }
    //     }
    //     foreach ($groupPay as $key => $valGroup) {
    //         foreach ($salesByMethodPay2 as $key => $valMpay) {
    //             $length = count($data);
    //             $convert = array();
    //             for ($i=1; $i <= $length ; $i++) { 
    //                 array_push($convert,array_values($data[$valMpay->r_t_tanggal]));
    //             }
                
    //         }
    //     }
    //     $output = array("data" => $convert);
        
    //     return response()->json($output);
    // }