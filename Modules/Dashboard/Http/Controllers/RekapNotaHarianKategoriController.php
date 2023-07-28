<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapNotaHarianKategoriController extends Controller
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
        $data->payment = DB::table('m_transaksi_tipe')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_nota_harian_kategori', compact('data'));
    }

    public function select_waroeng(Request $request)
    {
        if ($request->id_area != 'all') {
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
    }

    public function tanggal_rekap(Request $request)
    {
        $tanggal = DB::table('m_transaksi_tipe')
            ->select('m_t_t_id', 'm_t_t_name')
            ->orderby('m_t_t_id', 'ASC')
            ->get();

        $data = [];
        foreach ($tanggal as $val) {
            $data[] = $val->m_t_t_name;
        }
        return response()->json($data);
    }

    public function show(Request $request)
    {
        $tipeTransaksi = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id', 'asc')->get();
        $groupPay = ['cash', 'transfer'];
        $operator = DB::table('rekap_modal')
            ->where('rekap_modal_status', 'close');
        // ->whereRaw("to_char(rekap_modal_tanggal,'YYYY-MM-DD') = '{$request->tanggal}'")
        // ->where('rekap_modal_m_w_id', $request->waroeng)
        // ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $operator->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), [$start, $end]);
        } else {
            $operator->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        if ($request->area != 'all') {
            $operator->where('rekap_modal_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $operator->where('rekap_modal_m_w_id', $request->waroeng);
            }
        }
        $operator = $operator->orderby('rekap_modal_tanggal', 'asc')->get();

        $data = [];
        foreach ($operator as $key => $valOp) {
            $date = Carbon::parse($valOp->rekap_modal_tanggal)->format('Y-m-d');
            $salesByMethodPay = DB::table('m_transaksi_tipe')
                ->selectraw('MAX(m_t_t_name) name, MAX(users.name) username,
                            m_t_t_id, m_payment_method_type, rekap_modal_sesi,
                            r_t_m_w_nama,r_t_m_area_nama,r_t_tanggal,
                            COUNT(r_t_id) jml,
                            COALESCE(SUM(r_t_nominal),0) as nominal,
                            COALESCE(SUM(r_t_nominal_pajak),0) as pajak,
                            COALESCE(SUM(r_t_nominal_total_bayar),0) as tagihan,
                            COALESCE(SUM(r_t_nominal_kembalian),0) as kembalian,
                            COALESCE(SUM(r_p_t_nominal),0) as pay
                        ')
                ->join('rekap_transaksi', 'r_t_m_t_t_id', '=', 'm_t_t_id')
                ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', '=', 'r_t_id')
                ->join('m_payment_method', 'm_payment_method_id', '=', 'r_p_t_m_payment_method_id')
                ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                ->join('users', 'users_id', 'rekap_modal_created_by')
                ->where('r_t_status', 'paid')
                ->groupby('m_t_t_id', 'm_payment_method_type', 'r_t_m_w_nama', 'r_t_m_area_nama', 'r_t_tanggal', 'rekap_modal_sesi');
            // ->whereRaw("to_char(rekap_modal_tanggal,'YYYY-MM-DD') = '{$request->tanggal}'")
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $salesByMethodPay->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), [$start, $end]);
            } else {
                $salesByMethodPay->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
            }
            $salesByMethodPay = $salesByMethodPay->where('rekap_modal_id', $valOp->rekap_modal_id)
                ->orderby('r_t_tanggal', 'asc')
            // ->orderby('m_t_t_id','asc')
                ->get();
            foreach ($tipeTransaksi as $key => $valTrans) {
                $jmlNota = 0;
                foreach ($salesByMethodPay as $key => $valMpay) {
                    $data[$valOp->rekap_modal_id]['area'] = $valMpay->r_t_m_area_nama;
                    $data[$valOp->rekap_modal_id]['waroeng'] = $valMpay->r_t_m_w_nama;
                    $data[$valOp->rekap_modal_id]['tanggal'] = $valMpay->r_t_tanggal;
                    $data[$valOp->rekap_modal_id]['operator'] = $valMpay->username;
                    $data[$valOp->rekap_modal_id]['sesi'] = $valMpay->rekap_modal_sesi;
                    if ($valTrans->m_t_t_id == $valMpay->m_t_t_id) {
                        $jmlNota += $valMpay->jml;
                    }
                    $data[$valOp->rekap_modal_id]['jml_nota-' . $valTrans->m_t_t_name] = $jmlNota;
                }
                foreach ($groupPay as $key => $valGroup) {
                    $nominal = 0;
                    $pajak = 0;
                    foreach ($salesByMethodPay as $key => $valMpay) {
                        if ($valTrans->m_t_t_id == $valMpay->m_t_t_id && $valMpay->m_payment_method_type == $valGroup) {
                            // $nominal = $valMpay->pay;
                            $nominal = $valMpay->nominal;
                            $pajak = $valMpay->pajak;

                            // if ($valMpay->m_payment_method_type == 'cash') {
                            //     $nominal = $valMpay->pay - $valMpay->kembalian;
                            // }
                        }
                        $data[$valOp->rekap_modal_id][$valTrans->m_t_t_name . '-' . $valGroup] = number_format($nominal);
                        $data[$valOp->rekap_modal_id][$valTrans->m_t_t_name . '-' . $valGroup . '-pajak'] = number_format($pajak);
                    }
                }
            }
            $convert = [];
            foreach ($data as $row) {
                $convert[] = array_values($row);
            }
            $output = array("data" => $convert);
        }
        return response()->json($output);
    }

    // public function rekap_non_menu(Request $request)
    // {
    //    $typeTransaksi = DB::table('m_transaksi_tipe')->get();
    //    $sesi = DB::table('rekap_modal')
    //            ->join('users','users_id','=','rekap_modal_created_by')
    //            ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal)
    //            ->where('rekap_modal_m_w_id', $request->waroeng)
    //            ->where('rekap_modal_status', 'close')
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
    //    // return $listIceCream;
    //    $sales = [];
    //    foreach ($sesi as $key => $valSesi) {
    //        foreach ($typeTransaksi as $key => $valType) {
    //            $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Tipe'] = $valType->m_t_t_name;
    //            $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Menu'] = 0;
    //            $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Non Menu'] = 0;
    //            $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Ice Cream'] = 0;
    //            $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['KBD'] = 0;
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
    //                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Menu'] = number_format($menu->nominal);
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
    //                    ->whereNotIn('r_t_detail_m_produk_id',$listKbd)
    //                    ->whereNotIn('r_t_detail_m_produk_id',$listIceCream)
    //                    ->groupBy('r_t_rekap_modal_id')
    //                    ->first();
    //            if (!empty($nonMenu)) {
    //                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Non Menu'] = number_format($nonMenu->nominal);
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
    //                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Ice Cream'] = number_format($iceCream->nominal);
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
    //                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['KBD'] = number_format($kbd->nominal);
    //            }
    //        }
    //    }

    //    $tanggal = Carbon::parse($request->tanggal)->format('d M Y');
    //    $data = [
    //        'title' => 'Laporan Menu non Menu',
    //        'sales' => $sales,
    //        'tanggal' => $tanggal,
    //        'tglCetak' => Carbon::now()->format('Y-m-d H:i:s')
    //    ];
    //    $pdf = pdf::loadview('dashboard::lap_non_menu', $data)->setPaper('a4');
    //    return $pdf->download('lap_non_menu_'.tgl_indo($request->tanggal).'.pdf');
    // }

    // public function show(Request $request)
    // {
    //     $tipeTransaksi = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id','asc')->get();
    //     $groupPay = ['cash','transfer'];
    //     $operator = DB::table('rekap_modal')
    //         ->whereRaw("to_char(rekap_modal_tanggal,'YYYY-MM-DD') = '{$request->tanggal}'")
    //         ->where('rekap_modal_m_w_id', $request->waroeng)
    //         ->get();

    //     $data = [];
    //     foreach ($operator as $key => $valOp) {
    //         $date = Carbon::parse($valOp->rekap_modal_tanggal)->format('Y-m-d');
    //         $salesByMethodPay = DB::table('m_transaksi_tipe')
    //                     ->selectraw('MAX(m_t_t_name) name, MAX(users.name) username,
    //                         m_t_t_id, m_payment_method_type,
    //                         r_t_m_w_nama,r_t_m_area_nama,r_t_tanggal,
    //                         COUNT(r_t_id) jml,
    //                         COALESCE(SUM(r_t_nominal),0) as nominal,
    //                         COALESCE(SUM(r_t_nominal_pajak),0) as pajak,
    //                         COALESCE(SUM(r_t_nominal_total_bayar),0) as tagihan,
    //                         COALESCE(SUM(r_t_nominal_kembalian),0) as kembalian,
    //                         COALESCE(SUM(r_p_t_nominal),0) as pay
    //                     ')
    //                     ->join('rekap_transaksi','r_t_m_t_t_id','=','m_t_t_id')
    //                     ->join('rekap_payment_transaksi','r_p_t_r_t_id','=','r_t_id')
    //                     ->join('m_payment_method','m_payment_method_id','=','r_p_t_m_payment_method_id')
    //                     ->join('rekap_modal','rekap_modal_id','r_t_rekap_modal_id')
    //                     ->join('users','users_id','rekap_modal_created_by')
    //                     ->where('r_t_status','paid')
    //                     ->groupby('m_t_t_id','m_payment_method_type','r_t_m_w_nama','r_t_m_area_nama','r_t_tanggal')
    //                     ->whereRaw("to_char(rekap_modal_tanggal,'YYYY-MM-DD') = '{$request->tanggal}'")
    //                     ->where('rekap_modal_id',$valOp->rekap_modal_id)
    //                     // ->where('m_t_t_id',$valTrans->m_t_t_id)
    //                     // ->where('m_payment_method_type',$valGroup)
    //                     ->orderby('m_t_t_id','asc')
    //                     ->get();
    //         foreach ($tipeTransaksi as $key => $valTrans) {
    //             $jmlNota = 0;
    //             foreach ($salesByMethodPay as $key => $valMpay) {
    //                 $data[$valOp->rekap_modal_id]['area'] = $valMpay->r_t_m_area_nama;
    //                 $data[$valOp->rekap_modal_id]['waroeng'] = $valMpay->r_t_m_w_nama;
    //                 $data[$valOp->rekap_modal_id]['tanggal'] = $valMpay->r_t_tanggal;
    //                 $data[$valOp->rekap_modal_id]['operator'] = $valMpay->username;
    //                 if ($valTrans->m_t_t_id == $valMpay->m_t_t_id) {
    //                     $jmlNota += $valMpay->jml;
    //                 }
    //                 $data[$valOp->rekap_modal_id]['jml_nota-'.$valTrans->m_t_t_name] = $jmlNota;
    //             }
    //             foreach ($groupPay as $key => $valGroup) {
    //                 $nominal = 0;
    //                 $pajak = 0;
    //                 foreach ($salesByMethodPay as $key => $valMpay) {
    //                         if ($valTrans->m_t_t_id == $valMpay->m_t_t_id && $valMpay->m_payment_method_type == $valGroup) {
    //                             // $nominal = $valMpay->pay;
    //                             $nominal = $valMpay->nominal;
    //                             $pajak = $valMpay->pajak;

    //                             // if ($valMpay->m_payment_method_type == 'cash') {
    //                             //     $nominal = $valMpay->pay - $valMpay->kembalian;
    //                             // }
    //                         }
    //                         $data[$valOp->rekap_modal_id][$valTrans->m_t_t_name.'-'.$valGroup] = number_format($nominal);
    //                         $data[$valOp->rekap_modal_id][$valTrans->m_t_t_name.'-'.$valGroup.'-pajak'] = number_format($pajak);
    //                 }
    //             }
    //         }
    //         $convert = [];
    //         foreach ($data as $row) {
    //             $convert[] = array_values($row);
    //         }
    //         $output = array("data" => $convert);
    //     }
    //     return response()->json($output);
    // }

}
