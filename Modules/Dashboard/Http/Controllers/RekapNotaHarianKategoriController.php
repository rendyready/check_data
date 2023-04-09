<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
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
                    ->groupby('m_t_t_id','m_payment_method_type','r_t_m_w_nama','r_t_m_area_nama','r_t_tanggal', 'rekap_modal_id')
                    ->orderby('m_t_t_id','asc')
                    ->where('r_t_m_w_id', $request->waroeng);
        if (strpos($request->tanggal, 'to') !== false) {   
            $dates = explode('to' ,$request->tanggal);  
            $salesByMethodPay->whereBetween('r_t_tanggal', $dates);
        }else{
            $salesByMethodPay->where('r_t_tanggal', $request->tanggal);
        }

        return $salesByMethodPay2 = $salesByMethodPay->get();
          
        $tipeTransaksi = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id','asc')->get();
        $groupPay = ['cash','transfer'];

        $data = [];
        foreach ($tipeTransaksi as $key => $valTrans) {
            foreach ($groupPay as $key => $valGroup) {
                foreach ($salesByMethodPay2 as $key => $valMpay) {
                    $data[$valMpay->r_t_tanggal]['area'] = $valMpay->r_t_m_area_nama;
                    $data[$valMpay->r_t_tanggal]['waroeng'] = $valMpay->r_t_m_w_nama;
                    $data[$valMpay->r_t_tanggal]['operator'] = $valMpay->name;
                    $data[$valMpay->r_t_tanggal]['tanggal'] = $valMpay->r_t_tanggal;
                    if ($valTrans->m_t_t_id == $valMpay->m_t_t_id) {
                        $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valGroup] = 0;
                        $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valGroup.'-pajak'] = 0;

                        $pay = $valMpay->pay;
                        if ($valMpay->m_payment_method_type == 'cash') {
                            $pay = $valMpay->pay - $valMpay->kembalian;
                        }
                        $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type] = number_format($pay);
                        $data[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type.'-pajak'] = number_format($valMpay->pajak);
                    }
                    $length = count($data);
                    $convert = array();
                    for ($i=1; $i <= $length ; $i++) { 
                        array_push($convert,array_values($data[$valMpay->r_t_tanggal]));
                    }  
                }
            }
        }
               
        $output = array("data" => $convert);
        return response()->json($output);
    }

    public function edit($id)
    {
        return view('dashboard::edit');
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