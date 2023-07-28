<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapNonMenuController extends Controller
{

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
        return view('dashboard::rekap_non_menu', compact('data'));
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

    public function show(Request $request)
    {
        $refund = DB::table('rekap_refund_detail')
            ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
            ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->selectRaw('
                        MAX(r_r_tanggal) tanggal,
                        MAX(r_t_m_w_nama) m_w_nama,
                        MAX(rekap_modal_sesi) sesi,
                        rekap_modal_id,
                        r_r_detail_m_produk_id,
                        r_t_m_w_id,
                        r_t_m_t_t_id,
                        SUM(r_r_detail_reguler_price*r_r_detail_qty) nom_refund,
                        SUM(r_r_detail_nominal_pajak) pajak_refund
                        ');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $refund->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), $dates);
        } else {
            $refund->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        if ($request->area != 'all') {
            $refund->where('rekap_modal_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $refund->where('rekap_modal_m_w_id', $request->waroeng);
            }
        }
        $refund = $refund->groupBy('rekap_modal_id', 'r_r_detail_m_produk_id', 'r_t_m_w_id', 'r_t_m_t_t_id')
            ->orderBy('tanggal', 'asc')
            ->orderBy('m_w_nama', 'asc')
            ->orderBy('sesi', 'asc')
            ->get();

        $refundCek = $refund->first();

        $rekap = DB::table('rekap_transaksi_detail')
            ->selectRaw('
                        rekap_modal_id,
                        MAX(r_t_m_area_id) m_area_id,
                        MAX(r_t_m_area_nama) m_area_nama,
                        r_t_m_w_id m_w_id,
                        MAX(r_t_m_w_nama) m_w_nama,
                        MAX(r_t_tanggal) tanggal,
                        MAX(rekap_modal_sesi) sesi,
                        MAX(name) kasir,
                        MAX(r_t_m_t_t_id) type_id,
                        MAX(m_t_t_name) type_name,
                        r_t_detail_m_produk_id m_produk_id,
                        MAX(r_t_detail_m_produk_nama) m_produk_nama,
                        SUM(r_t_detail_reguler_price*r_t_detail_qty) nominal,
                        SUM(r_t_detail_nominal_pajak) pajak
                    ')
            ->join('rekap_transaksi', 'r_t_detail_r_t_id', 'r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $rekap->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), $dates);
        } else {
            $rekap->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        if ($request->area != 'all') {
            $rekap->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $rekap->where('r_t_m_w_id', $request->waroeng);
            }
        }
        $rekap = $rekap->where('r_t_detail_status', 'paid')
            ->groupBy('rekap_modal_id', 'r_t_detail_m_produk_id', 'r_t_m_w_id', 'm_t_t_id')
            ->orderBy('tanggal', 'asc')
            ->orderBy('m_w_nama', 'asc')
            ->orderBy('sesi', 'asc')
            ->get();

        $countNota = DB::table('rekap_transaksi')
            ->selectRaw('r_t_m_t_t_id type_id, r_t_rekap_modal_id modal_id, COUNT(r_t_id) jml')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $rekap->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), $dates);
        } else {
            $rekap->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        if ($request->area != 'all') {
            $countNota->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $countNota->where('r_t_m_w_id', $request->waroeng);
            }
        }
        $countNota = $countNota->where('r_t_status', 'paid')
            ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
            ->get();

        $countNotaArray = [];
        foreach ($countNota as $keyNot => $valNot) {
            $countNotaArray[$valNot->type_id . "-" . $valNot->modal_id] = $valNot->jml;
        }

        $getMenu = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereNotIn('m_produk_m_jenis_produk_id', [9, 11, 12, 13])->get();

        $listMenu = [];
        foreach ($getMenu as $key => $valMenu) {
            array_push($listMenu, $valMenu->m_produk_id);
        }

        $getNonMenu = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereIn('m_produk_m_jenis_produk_id', [9, 11])->get();
        $listNonMenu = [];
        foreach ($getNonMenu as $key => $valMenu) {
            array_push($listNonMenu, $valMenu->m_produk_id);
        }

        $arrayListRekap = [];
        foreach ($rekap as $keyRekap => $valRekap) {
            array_push($arrayListRekap, $valRekap->rekap_modal_id);
        }

        $listRekap = array_unique($arrayListRekap);
        // return $listRekap;
        $getIceCream = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [20, 22, 23, 24, 25])->get();
        $listIceCream = [];
        foreach ($getIceCream as $key => $valMenu) {
            array_push($listIceCream, $valMenu->m_produk_id);
        }
        $getMineral = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [12])->get();
        $listMineral = [];
        foreach ($getMineral as $key => $valMenu) {
            array_push($listMineral, $valMenu->m_produk_id);
        }

        $getKerupuk = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [47])->get();
        $listKerupuk = [];
        foreach ($getKerupuk as $key => $valMenu) {
            array_push($listKerupuk, $valMenu->m_produk_id);
        }

        $getWbdFrozen = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [45])->get();
        $listWbdFrozen = [];
        foreach ($getWbdFrozen as $key => $valMenu) {
            array_push($listWbdFrozen, $valMenu->m_produk_id);
        }

        $getKbd = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereIn('m_produk_m_jenis_produk_id', [11])
            ->get();
        $listKbd = [];
        foreach ($getKbd as $key => $valMenu) {
            array_push($listKbd, $valMenu->m_produk_id);
        }

        #List of transaction type
        $tipe = ['dine in', 'take away', 'grab', 'gojek', 'shopeefood', 'grabmart'];

        $data = [];
        foreach ($listRekap as $keyListRekap => $valListRekap) {
            ${$valListRekap . '-icecream'} = 0;
            ${$valListRekap . '-mineral'} = 0;
            ${$valListRekap . '-krupuk'} = 0;
            ${$valListRekap . '-wbdbb'} = 0;
            ${$valListRekap . '-wbdfrozen'} = 0;
            ${$valListRekap . '-pajakreguler'} = 0;
            ${$valListRekap . '-pajakojol'} = 0;

            foreach ($tipe as $keyTipe => $valTipe) {
                ${$valListRekap . '-' . $valTipe . '-menu'} = 0;
                ${$valListRekap . '-' . $valTipe . '-menupajak'} = 0;
                ${$valListRekap . '-' . $valTipe . '-menunonpajak'} = 0;
                ${$valListRekap . '-' . $valTipe . '-nonmenu'} = 0;
                ${$valListRekap . '-' . $valTipe . '-jmlnota'} = 0;

                foreach ($rekap as $keyRekap => $valRekap) {
                    if ($valRekap->rekap_modal_id == $valListRekap) {
                        $data[$valListRekap]['area'] = $valRekap->m_area_nama;
                        $data[$valListRekap]['waroeng'] = $valRekap->m_w_nama;
                        $data[$valListRekap]['tanggal'] = date('d-m-Y', strtotime($valRekap->tanggal));
                        $data[$valListRekap]['sesi'] = $valRekap->sesi;
                        $data[$valListRekap]['operator'] = $valRekap->kasir;
                        if ($valRekap->type_name == $valTipe) {
                            if (in_array($valRekap->m_produk_id, $listMenu)) {
                                $valMenu = $valRekap->nominal;
                                if (!empty($refundCek)) {
                                    foreach ($refund as $valRefund) {
                                        if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                            $valMenu = $valRekap->nominal - $valRefund->nom_refund;
                                        }
                                    }
                                }
                                ${$valListRekap . '-' . $valTipe . '-menu'} += $valMenu;
                            }
                            if (in_array($valRekap->m_produk_id, $listMenu) && $valRekap->pajak != 0) {
                                $valMenu = $valRekap->nominal;
                                if (!empty($refundCek)) {
                                    foreach ($refund as $valRefund) {
                                        if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                            $valMenu = $valRekap->nominal - $valRefund->nom_refund;
                                        }
                                    }
                                }
                                ${$valListRekap . '-' . $valTipe . '-menupajak'} += $valMenu;
                            }
                            if (in_array($valRekap->m_produk_id, $listMenu) && $valRekap->pajak == 0) {
                                $valMenu = $valRekap->nominal;
                                if (!empty($refundCek)) {
                                    foreach ($refund as $valRefund) {
                                        if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                            $valMenu = $valRekap->nominal - $valRefund->nom_refund;
                                        }
                                    }
                                }
                                ${$valListRekap . '-' . $valTipe . '-menunonpajak'} += $valMenu;
                            }
                            if (in_array($valRekap->m_produk_id, $listNonMenu)) {
                                $valNonMenu = $valRekap->nominal;
                                if (!empty($refundCek)) {
                                    foreach ($refund as $valRefund) {
                                        if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                            $valNonMenu = $valRekap->nominal - $valRefund->nom_refund;
                                        }
                                    }
                                }
                                ${$valListRekap . '-' . $valTipe . '-nonmenu'} += $valNonMenu;
                            }

                            if (isset($countNotaArray[$valRekap->type_id . '-' . $valListRekap])) {
                                ${$valListRekap . '-' . $valTipe . '-jmlnota'} = $countNotaArray[$valRekap->type_id . '-' . $valListRekap];
                            }
                        }
                        $data[$valListRekap][$valTipe . '-menu'] = number_format(${$valListRekap . '-' . $valTipe . '-menu'});
                        $data[$valListRekap][$valTipe . '-menupajak'] = number_format(${$valListRekap . '-' . $valTipe . '-menupajak'});
                        $data[$valListRekap][$valTipe . '-menunonpajak'] = number_format(${$valListRekap . '-' . $valTipe . '-menunonpajak'});
                        $data[$valListRekap][$valTipe . '-nonmenu'] = number_format(${$valListRekap . '-' . $valTipe . '-nonmenu'});
                        $data[$valListRekap][$valTipe . '-jmlnota'] = ${$valRekap->rekap_modal_id . '-' . $valTipe . '-jmlnota'};
                    }
                }
            }
            // return $data;
            foreach ($rekap as $keyRekap => $valRekap) {
                if ($valRekap->rekap_modal_id == $valListRekap) {
                    if (in_array($valRekap->m_produk_id, $listIceCream)) {
                        $valIceCream = $valRekap->nominal;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valIceCream = $valRekap->nominal - $valRefund->nom_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-icecream'} += $valIceCream;
                    }
                    $data[$valListRekap]['icecream'] = number_format(${$valListRekap . '-icecream'});

                    if (in_array($valRekap->m_produk_id, $listMineral)) {
                        $valMineral = $valRekap->nominal;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valMineral = $valRekap->nominal - $valRefund->nom_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-mineral'} += $valMineral;
                    }
                    $data[$valListRekap]['mineral'] = number_format(${$valListRekap . '-mineral'});

                    if (in_array($valRekap->m_produk_id, $listKerupuk)) {
                        $valKerupuk = $valRekap->nominal;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valKerupuk = $valRekap->nominal - $valRefund->nom_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-krupuk'} += $valKerupuk;
                    }
                    $data[$valListRekap]['krupuk'] = number_format(${$valListRekap . '-krupuk'});

                    if (in_array($valRekap->m_produk_id, $listKbd) && !in_array($valRekap->m_produk_id, $listWbdFrozen)) {
                        $valWbdBB = $valRekap->nominal;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valWbdBB = $valRekap->nominal - $valRefund->nom_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-wbdbb'} += $valWbdBB;
                    }
                    $data[$valListRekap]['wbdbb'] = number_format(${$valListRekap . '-wbdbb'});

                    if (in_array($valRekap->m_produk_id, $listWbdFrozen)) {
                        $valWbdFrozen = $valRekap->nominal;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valWbdFrozen = $valRekap->nominal - $valRefund->nom_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-wbdfrozen'} += $valWbdFrozen;
                    }
                    $data[$valListRekap]['wbdfrozen'] = number_format(${$valListRekap . '-wbdfrozen'});

                    if (in_array($valRekap->type_name, ['dine in', 'take away'])) {
                        $valPajak = $valRekap->pajak;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valPajak = $valRekap->pajak - $valRefund->pajak_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-pajakreguler'} += $valPajak;
                    } else {
                        $valPajak = $valRekap->nominal * 0.10;
                        if (!empty($refundCek)) {
                            foreach ($refund as $valRefund) {
                                if ($valRekap->m_produk_id == $valRefund->r_r_detail_m_produk_id && $valRekap->tanggal == $valRefund->tanggal && $valRekap->sesi == $valRefund->sesi && $valRekap->type_id == $valRefund->r_t_m_t_t_id) {
                                    $valPajak = ($valRekap->nominal * 0.10) - $valRefund->pajak_refund;
                                }
                            }
                        }
                        ${$valListRekap . '-pajakojol'} += $valPajak;
                    }
                    $data[$valListRekap]['pajakreguler'] = number_format(${$valListRekap . '-pajakreguler'});
                    $data[$valListRekap]['pajakojol'] = number_format(${$valListRekap . '-pajakojol'});
                }
            }
        }
        $convert = [];
        foreach ($data as $row) {
            $convert[] = array_values($row);
        }

        $output = array("data" => $convert);
        return response()->json($output);
    }

    public function showori(Request $request)
    {
        $rekap = DB::table('rekap_transaksi_detail')
            ->selectRaw('
                        rekap_modal_id,
                        MAX(r_t_m_area_id) m_area_id,
                        MAX(r_t_m_area_nama) m_area_nama,
                        r_t_m_w_id m_w_id,
                        MAX(r_t_m_w_nama) m_w_nama,
                        MAX(r_t_tanggal) tanggal,
                        MAX(rekap_modal_sesi) sesi,
                        MAX(name) kasir,
                        MAX(r_t_m_t_t_id) type_id,
                        MAX(m_t_t_name) type_name,
                        r_t_detail_m_produk_id m_produk_id,
                        MAX(r_t_detail_m_produk_nama) m_produk_nama,
                        SUM(r_t_detail_reguler_price*r_t_detail_qty) nominal,
                        SUM(r_t_detail_nominal_pajak) pajak
                    ')
            ->join('rekap_transaksi', 'r_t_detail_r_t_id', 'r_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->join('users', 'users_id', 'rekap_modal_created_by')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $rekap->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), $dates);
        } else {
            $rekap->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        if ($request->area != 'all') {
            $rekap->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $rekap->where('r_t_m_w_id', $request->waroeng);
            }
        }
        $rekap = $rekap->where('r_t_detail_status', 'paid')
            ->groupBy('rekap_modal_id', 'r_t_detail_m_produk_id', 'r_t_m_w_id', 'm_t_t_id')
            ->orderBy('tanggal', 'asc')
            ->orderBy('m_w_nama', 'asc')
            ->orderBy('sesi', 'asc')
            ->get();

        $countNota = DB::table('rekap_transaksi')
            ->selectRaw('r_t_m_t_t_id type_id, r_t_rekap_modal_id modal_id, COUNT(r_t_id) jml')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $rekap->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), $dates);
        } else {
            $rekap->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        if ($request->area != 'all') {
            $countNota->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $countNota->where('r_t_m_w_id', $request->waroeng);
            }
        }
        $countNota = $countNota->where('r_t_status', 'paid')
            ->groupBy('r_t_rekap_modal_id', 'r_t_m_t_t_id')
            ->get();

        $countNotaArray = [];
        foreach ($countNota as $keyNot => $valNot) {
            $countNotaArray[$valNot->type_id . "-" . $valNot->modal_id] = $valNot->jml;
        }

        $getMenu = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereNotIn('m_produk_m_jenis_produk_id', [9, 11, 12, 13])->get();

        $listMenu = [];
        foreach ($getMenu as $key => $valMenu) {
            array_push($listMenu, $valMenu->m_produk_id);
        }

        $getNonMenu = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereIn('m_produk_m_jenis_produk_id', [9, 11])->get();
        $listNonMenu = [];
        foreach ($getNonMenu as $key => $valMenu) {
            array_push($listNonMenu, $valMenu->m_produk_id);
        }

        $arrayListRekap = [];
        foreach ($rekap as $keyRekap => $valRekap) {
            array_push($arrayListRekap, $valRekap->rekap_modal_id);
        }

        $listRekap = array_unique($arrayListRekap);
        // return $listRekap;
        $getIceCream = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [20, 22, 23, 24, 25])->get();
        $listIceCream = [];
        foreach ($getIceCream as $key => $valMenu) {
            array_push($listIceCream, $valMenu->m_produk_id);
        }
        $getMineral = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [12])->get();
        $listMineral = [];
        foreach ($getMineral as $key => $valMenu) {
            array_push($listMineral, $valMenu->m_produk_id);
        }

        $getKerupuk = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [47])->get();
        $listKerupuk = [];
        foreach ($getKerupuk as $key => $valMenu) {
            array_push($listKerupuk, $valMenu->m_produk_id);
        }

        $getWbdFrozen = DB::table('m_produk')
            ->join('config_sub_jenis_produk', 'config_sub_jenis_produk_m_produk_id', '=', 'm_produk_id')
            ->select('m_produk_id')
            ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id', [45])->get();
        $listWbdFrozen = [];
        foreach ($getWbdFrozen as $key => $valMenu) {
            array_push($listWbdFrozen, $valMenu->m_produk_id);
        }

        $getKbd = DB::table('m_produk')
            ->select('m_produk_id')
            ->whereIn('m_produk_m_jenis_produk_id', [11])
            ->get();
        $listKbd = [];
        foreach ($getKbd as $key => $valMenu) {
            array_push($listKbd, $valMenu->m_produk_id);
        }

        #List of transaction type
        $tipe = ['dine in', 'take away', 'grab', 'gojek', 'shopeefood', 'grabmart'];

        $data = [];
        foreach ($listRekap as $keyListRekap => $valListRekap) {
            ${$valListRekap . '-icecream'} = 0;
            ${$valListRekap . '-mineral'} = 0;
            ${$valListRekap . '-krupuk'} = 0;
            ${$valListRekap . '-wbdbb'} = 0;
            ${$valListRekap . '-wbdfrozen'} = 0;
            ${$valListRekap . '-pajakreguler'} = 0;
            ${$valListRekap . '-pajakojol'} = 0;

            foreach ($tipe as $keyTipe => $valTipe) {
                ${$valListRekap . '-' . $valTipe . '-menu'} = 0;
                ${$valListRekap . '-' . $valTipe . '-nonmenu'} = 0;
                ${$valListRekap . '-' . $valTipe . '-jmlnota'} = 0;

                foreach ($rekap as $keyRekap => $valRekap) {
                    if ($valRekap->rekap_modal_id == $valListRekap) {
                        $data[$valListRekap]['area'] = $valRekap->m_area_nama;
                        $data[$valListRekap]['waroeng'] = $valRekap->m_w_nama;
                        $data[$valListRekap]['tanggal'] = date('d-m-Y', strtotime($valRekap->tanggal));
                        $data[$valListRekap]['sesi'] = $valRekap->sesi;
                        $data[$valListRekap]['operator'] = $valRekap->kasir;
                        if ($valRekap->type_name == $valTipe) {
                            if (in_array($valRekap->m_produk_id, $listMenu)) {
                                ${$valListRekap . '-' . $valTipe . '-menu'} += $valRekap->nominal;
                            }
                            if (in_array($valRekap->m_produk_id, $listNonMenu)) {
                                ${$valListRekap . '-' . $valTipe . '-nonmenu'} += $valRekap->nominal;
                            }

                            if (isset($countNotaArray[$valRekap->type_id . '-' . $valListRekap])) {
                                ${$valListRekap . '-' . $valTipe . '-jmlnota'} = $countNotaArray[$valRekap->type_id . '-' . $valListRekap];
                            }
                        }
                        $data[$valListRekap][$valTipe . '-menu'] = number_format(${$valListRekap . '-' . $valTipe . '-menu'});
                        $data[$valListRekap][$valTipe . '-nonmenu'] = number_format(${$valListRekap . '-' . $valTipe . '-nonmenu'});
                        $data[$valListRekap][$valTipe . '-jmlnota'] = ${$valRekap->rekap_modal_id . '-' . $valTipe . '-jmlnota'};
                    }
                }
            }
            // return $data;
            foreach ($rekap as $keyRekap => $valRekap) {
                if ($valRekap->rekap_modal_id == $valListRekap) {
                    if (in_array($valRekap->m_produk_id, $listIceCream)) {
                        ${$valListRekap . '-icecream'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['icecream'] = number_format(${$valListRekap . '-icecream'});

                    if (in_array($valRekap->m_produk_id, $listMineral)) {
                        ${$valListRekap . '-mineral'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['mineral'] = number_format(${$valListRekap . '-mineral'});

                    if (in_array($valRekap->m_produk_id, $listKerupuk)) {
                        ${$valListRekap . '-krupuk'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['krupuk'] = number_format(${$valListRekap . '-krupuk'});

                    if (in_array($valRekap->m_produk_id, $listKbd) && !in_array($valRekap->m_produk_id, $listWbdFrozen)) {
                        ${$valListRekap . '-wbdbb'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['wbdbb'] = number_format(${$valListRekap . '-wbdbb'});

                    if (in_array($valRekap->m_produk_id, $listWbdFrozen)) {
                        ${$valListRekap . '-wbdfrozen'} += $valRekap->nominal;
                    }
                    $data[$valListRekap]['wbdfrozen'] = number_format(${$valListRekap . '-wbdfrozen'});

                    if (in_array($valRekap->type_name, ['dine in', 'take away'])) {
                        ${$valListRekap . '-pajakreguler'} += $valRekap->pajak;
                    } else {
                        $nominalPajak = $valRekap->nominal * 0.10;
                        ${$valListRekap . '-pajakojol'} += $nominalPajak;
                    }
                    $data[$valListRekap]['pajakreguler'] = number_format(${$valListRekap . '-pajakreguler'});
                    $data[$valListRekap]['pajakojol'] = number_format(${$valListRekap . '-pajakojol'});
                }
            }
        }
        $convert = [];
        foreach ($data as $row) {
            $convert[] = array_values($row);
        }

        $output = array("data" => $convert);
        return response()->json($output);
    }
}
