<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class RekapPenjualanKategoriMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
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
        $data->payment = DB::table('m_jenis_produk')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_penj_kategori_menu', compact('data'));
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

    public function select_user(Request $request)
    {
        $user = DB::table('users')
            ->join('rekap_transaksi', 'r_t_created_by', 'users_id')
            ->select('users_id', 'name');
            if(in_array(Auth::user()->waroeng_id, $this->get_akses_area())){
                $user->where('waroeng_id', $request->id_waroeng);
            } else {
                $user->where('waroeng_id', Auth::user()->waroeng_id);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to' ,$request->tanggal);
                $user->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $user->where('r_t_tanggal', $request->tanggal);
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

    public function show(Request $request)
    {
        $methodPay = DB::table('m_jenis_produk')
                ->orderBy('m_jenis_produk_id', 'ASC')
                ->get();
        
                $trans1 = DB::table('rekap_transaksi')
                    ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                    ->join('m_w', 'm_w_code', 'r_t_m_w_code');
                    if($request->area != 'all'){
                        $trans1->where('r_t_m_area_id', $request->area);
                        if($request->waroeng != 'all') {
                            $trans1->where('r_t_m_w_id', $request->waroeng);
                        }
                    }
                    if($request->show_operator == 'ya'){
                        if($request->operator != 'all'){
                        $trans1->where('r_t_created_by', $request->operator);
                        }
                    }
                    if (strpos($request->tanggal, 'to') !== false) {
                        $dates = explode('to' ,$request->tanggal);
                        $trans1->whereBetween('r_t_tanggal', $dates);
                    } else {
                        $trans1->where('r_t_tanggal', $request->tanggal);
                    }
                    if($request->show_operator == 'ya'){
                        $trans1->join('users', 'users_id', 'r_t_created_by')
                                ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'r_t_created_by')
                                ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama', 'r_t_created_by');
                    } else {
                        $trans1->select('r_t_tanggal', 'm_area_nama', 'm_w_nama')
                                ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama');
                    }
            $trans = $trans1->orderBy('r_t_tanggal', 'ASC')
                    ->get(); 
            
        $trans1->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id');
                if (strpos($request->tanggal, 'to') !== false) {
                    $dates = explode('to' ,$request->tanggal);
                    $trans1->whereBetween('r_t_tanggal', $dates);
                } else {
                    $trans1->where('r_t_tanggal', $request->tanggal);
                }
        $trans1->orderBy('m_produk_m_jenis_produk_id', 'ASC');
                if($request->show_operator == 'ya'){
                $trans1->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total, r_t_created_by')
                ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price', 'r_t_created_by');
                } else {
                    $trans1->selectRaw('m_produk_m_jenis_produk_id, r_t_tanggal, r_t_detail_reguler_price, SUM(r_t_detail_qty) as total')
                    ->groupBy('r_t_tanggal', 'm_produk_m_jenis_produk_id', 'r_t_detail_reguler_price');
                }
                $trans2 = $trans1->get();
        
            $data =[];
            $i =1;
            foreach ($trans as $key => $valTrans) {
                $data[$i]['area'] = $valTrans->m_area_nama;
                $data[$i]['waroeng'] = $valTrans->m_w_nama;
                $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
                if($request->show_operator == 'ya'){
                $data[$i]['operator'] = $valTrans->name;
                }
                $grandTotal = 0;
                foreach ($methodPay as $key => $valPay) {
                    $total = 0;
                    foreach ($trans2 as $key2 => $valTrans2) {
                        if ($valPay->m_jenis_produk_id == $valTrans2->m_produk_m_jenis_produk_id && $valTrans2->r_t_tanggal == $valTrans->r_t_tanggal && $valTrans2->r_t_created_by == $valTrans->r_t_created_by) {
                            $total += $valTrans2->total * $valTrans2->r_t_detail_reguler_price;
                        }
                    }
                    $data[$i][$valPay->m_jenis_produk_nama] = number_format($total);
                    $grandTotal += $total;
                }
                $data[$i]['Total'] = number_format($grandTotal);
                $i++; 
            }
            
            $length = count($data);
            $convert = array();
            for ($i=1; $i <= $length ; $i++) { 
                array_push($convert,array_values($data[$i]));
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
       // return $listIceCream;
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
       $pdf = pdf::loadview('dashboard::lap_non_menu', $data)->setPaper('a4');
       return $pdf->download('lap_non_menu_'.tgl_indo($request->tanggal).'.pdf');
    //    return view('dashboard::lap_non_menu', $data);
    }
}

