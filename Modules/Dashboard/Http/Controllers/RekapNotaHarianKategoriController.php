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
        // $data->user = DB::table('users')
        //     ->orderby('id', 'ASC')
        //     ->get();
        $data->payment = DB::table('m_transaksi_tipe')
            ->orderby('id', 'ASC')
            ->get();
        return view('dashboard::rekap_nota_harian_kategori', compact('data'));
    }

    public function getSummarySales()
    {
       $salesByMethodPay = DB::table('m_transaksi_tipe')
            ->selectraw('MAX(m_t_t_name) name,
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
            ->where('r_t_created_by','8')
            ->where('r_t_status','paid')
            ->groupby('m_t_t_id','m_payment_method_type','r_t_m_w_nama','r_t_m_area_nama','r_t_tanggal')
            ->orderby('m_t_t_id','asc')
            ->get();

        $tipeTransaksi = DB::table('m_transaksi_tipe')->orderBy('m_t_t_id','asc')->get();
        $groupPay = ['cash','transfer'];

        $mySale = [];
        foreach ($tipeTransaksi as $key => $valTrans) {
            foreach ($groupPay as $key => $valGroup) {
                foreach ($salesByMethodPay as $key => $valMpay) {
                    $mySale[$valMpay->r_t_tanggal]['area'] = $valMpay->r_t_m_area_nama;
                    $mySale[$valMpay->r_t_tanggal]['waroeng'] = $valMpay->r_t_m_w_nama;
                    $mySale[$valMpay->r_t_tanggal]['tanggal'] = $valMpay->r_t_tanggal;

                    if ($valTrans->m_t_t_id == $valMpay->m_t_t_id) {
                        $mySale[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valGroup] = 0;
                        $mySale[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valGroup.'-pajak'] = 0;

                        $pay = $valMpay->pay;
                        if ($valMpay->m_payment_method_type == 'cash') {
                            $pay = $valMpay->pay - $valMpay->kembalian;
                        }
                        $mySale[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type] = $pay;
                        $mySale[$valMpay->r_t_tanggal][$valTrans->m_t_t_name.'-'.$valMpay->m_payment_method_type.'-pajak'] = $valMpay->pajak;
                    }
                }
            }
        }

        return response($mySale);
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
            ->select('users_id', 'name')
            ->where('waroeng_id', $request->id_waroeng)
            ->orderBy('users_id', 'asc')
            ->get();
        $data = array();
        foreach ($user as $val) {
            $data[$val->users_id] = [$val->name];
        }
        return response()->json($data);
    }


    public function show(Request $request)
    {
        $dates = explode('to' ,$request->tanggal);

        $methodPay = DB::table('m_payment_method')
                ->select('m_payment_method_id', 'm_payment_method_type')
                ->groupby('m_payment_method_id', 'm_payment_method_type')
                ->get();
        if($request->show_operator == 'ya'){
            $trans = DB::table('rekap_transaksi')
                ->where('r_t_created_by', $request->operator)
                ->where('r_t_m_area_id', $request->area)
                ->where('r_t_m_w_id', $request->waroeng);

            $trans1 = $trans->whereBetween('r_t_tanggal', $dates)
                ->join('users', 'users_id', 'r_t_created_by')
                ->join('m_area', 'm_area_code', 'r_t_m_area_code')
                ->join('m_w', 'm_w_code', 'r_t_m_w_code')
                ->select('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                ->groupBy('r_t_tanggal', 'name', 'm_area_nama', 'm_w_nama')
                ->orderBy('r_t_tanggal', 'ASC')
                ->get();

        } else {
            if($request->area == '0'){
                $trans = DB::table('rekap_transaksi');
            } else {
                $trans = DB::table('rekap_transaksi')
                        ->where('r_t_m_area_id', $request->area);
                            if($request->waroeng != 'all') {
                                $trans->where('r_t_m_w_id', $request->waroeng);
                            }
            }
            $trans1 = $trans->whereBetween('r_t_tanggal', $dates)
            ->join('m_area', 'm_area_code', 'r_t_m_area_code')
            ->join('m_w', 'm_w_code', 'r_t_m_w_code')
            ->select('r_t_tanggal',  'm_area_nama', 'm_w_nama')
            ->groupBy('r_t_tanggal', 'm_area_nama', 'm_w_nama')
            ->orderBy('r_t_tanggal', 'ASC')
            ->get();
        }

        $trans2 = $trans->whereBetween('r_t_tanggal', $dates)
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->selectRaw('r_t_tanggal, r_p_t_m_payment_method_id, SUM(r_t_nominal_total_bayar) as total, SUM(r_t_nominal_pajak) as pajak')
            ->groupBy('r_t_tanggal', 'r_p_t_m_payment_method_id')
            ->orderBy('r_t_tanggal', 'ASC')
            ->get();

    $data =[];
    if($request->show_operator == 'ya'){
            $i =1;
            foreach ($trans1 as $key => $valTrans) {
                $data[$i]['area'] = $valTrans->m_area_nama;
                $data[$i]['waroeng'] = $valTrans->m_w_nama;
                $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
                $data[$i]['operator'] = $valTrans->name;
                foreach ($methodPay as $key => $valPay) {
                    $data[$i][$valPay->m_t_t_name] = 0;
                    foreach ($trans2 as $key2 => $valTrans2) {
                        if ($valPay->m_t_t_id == $valTrans2->r_t_m_t_t_id) {
                            $data[$i][$valPay->m_t_t_name] += rupiah($valTrans2->total, 0);
                        }
                        // if ($valPay->m_t_t_id == $valTrans2->r_t_m_t_t_id) {
                        //     $data[$i][$valPay->m_t_t_name] += rupiah($valTrans2->total, 0);
                        // }
                    }
                }
                $i++;
            }
            $length = count($data);
            $convert = array();
            for ($i=1; $i <= $length ; $i++) {
                array_push($convert,array_values($data[$i]));
            }
    } else {
        $i =1;
        foreach ($trans1 as $key => $valTrans){
            $data[$i]['area'] = $valTrans->m_area_nama;
            $data[$i]['waroeng'] = $valTrans->m_w_nama;
            $data[$i]['tanggal'] = date('d-m-Y', strtotime($valTrans->r_t_tanggal));
            foreach ($methodPay as $key => $valPay) {
                $data[$i][$valPay->m_payment_method_type] = 0;
                foreach ($trans2 as $key2 => $valTrans2) {
                if($valPay->m_payment_method_id == $valTrans2->r_p_t_m_payment_method_id){
                    if ($valPay->m_payment_method_id == '1') {
                        $data[$i][$valPay->m_payment_method_type] = rupiah($valTrans2->total, 0);
                    }
                    if ($valPay->m_payment_method_id != '1') {
                        $data[$i][$valPay->m_payment_method_type] = rupiah($valTrans2->total, 0);
                    }
                }
                }
            }
            $i++;
        }
        $length = count($data);
        $convert = array();
        for ($i=1; $i <= $length ; $i++) {
            array_push($convert,array_values($data[$i]));
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
