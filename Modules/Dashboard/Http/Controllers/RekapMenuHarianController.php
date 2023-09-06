<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapMenuHarianController extends Controller
{
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

        return view('dashboard::rekap_menu_harian', compact('data'));
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

    public function select_sif(Request $request)
    {
        $sesi = DB::table('rekap_modal')
            ->select('rekap_modal_sesi')
            ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->id_tanggal);
        if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
            $sesi->where('rekap_modal_m_w_id', $request->id_waroeng);
        } else {
            $sesi->where('rekap_modal_m_w_id', Auth::user()->waroeng_id);
        }
        $sesi = $sesi->orderBy('rekap_modal_sesi', 'asc')
            ->get();
        $data = array();
        foreach ($sesi as $val) {
            $data[$val->rekap_modal_sesi] = [$val->rekap_modal_sesi];
        }
        return response()->json($data);
    }

    public function select_trans(Request $request)
    {
        $trans = DB::table('m_transaksi_tipe')
            ->join('rekap_transaksi', 'r_t_m_t_t_id', 'm_t_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->select('m_t_t_id', 'm_t_t_name');
        if ($request->id_sif != 'all') {
            $trans->where('rekap_modal_sesi', $request->id_sif);
        }
        $trans = $trans->where('rekap_modal_m_w_id', $request->id_waroeng)
            ->orderBy('m_t_t_id', 'asc')
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
        $get_modal_id = DB::table('rekap_modal')
            ->select('rekap_modal_id', 'rekap_modal_status')
            ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal)
            ->where('rekap_modal_m_area_id', $request->area)
            ->where('rekap_modal_m_w_id', $request->waroeng)
            ->where('rekap_modal_sesi', $request->sesi)
            ->first();

        if ($get_modal_id && $get_modal_id->rekap_modal_status != 'close') {
            return response()->json(['messages' => 'Sesi ' . $request->sesi . ' belum melakukan tutup saldo/ tarikan. Transaksi dapat ditampilkan setelah kasir melakukan tutup saldo/ tarikan', 'type' => 'error']);
        }

        if ($get_modal_id != null) {
            $refundM = DB::table('rekap_refund_detail')
                ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
                ->join('rekap_modal', 'rekap_modal_id', 'r_r_rekap_modal_id')
                ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->where('rekap_modal_id', $get_modal_id->rekap_modal_id);
            $refund = $refundM->get();
            $refund2 = $refundM->first();

            // $garansi = DB::table('rekap_garansi')
            //     ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            //     ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            //     ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            //     ->select('rekap_garansi_m_produk_id',
            //         'rekap_garansi_qty as qty',
            //         'r_t_tanggal',
            //         'rekap_modal_sesi',
            //         'm_t_t_id')
            //     ->where('rekap_modal_id', $get_modal_id->rekap_modal_id);
            // $garansi_qty = $garansi->get();
            // $garansi_notnull = $garansi->first();

            // $garansi_only = DB::table('rekap_garansi')
            //     ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            //     ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            //     ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            //     ->join('m_produk', 'm_produk_id', 'rekap_garansi_m_produk_id')
            //     ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            //     ->select('rekap_garansi_m_produk_id',
            //         'rekap_garansi_m_produk_nama as menu_gar',
            //         'rekap_garansi_reguler_price as harga_garansi',
            //         'rekap_garansi_qty as qty_gar',
            //         'm_jenis_produk_nama as jenis_produk_gar',
            //         'r_t_tanggal as tanggal_gar',
            //         'r_t_m_w_nama as waroeng_gar',
            //         'rekap_modal_sesi',
            //         'm_t_t_id',
            //         'm_t_t_name as tipe_gar'
            //     )
            //     ->where('rekap_modal_id', $get_modal_id->rekap_modal_id);
            // $garansi_only_qty = $garansi_only->get();
            // $garansi_only_notnull = $garansi_only->first();

            $garansi = DB::table('rekap_garansi')
                ->leftJoin('rekap_transaksi', 'rekap_garansi.rekap_garansi_r_t_id', '=', 'rekap_transaksi.r_t_id')
                ->leftJoin('m_produk', 'm_produk.m_produk_id', '=', 'rekap_garansi.rekap_garansi_m_produk_id')
                ->leftJoin('m_jenis_produk', 'm_jenis_produk.m_jenis_produk_id', '=', 'm_produk.m_produk_m_jenis_produk_id')
                ->leftJoin('m_transaksi_tipe', 'm_transaksi_tipe.m_t_t_id', '=', 'rekap_transaksi.r_t_m_t_t_id')
                ->leftJoin('rekap_modal', 'rekap_modal.rekap_modal_id', '=', 'rekap_transaksi.r_t_rekap_modal_id')
                ->whereDate('rekap_modal.rekap_modal_tanggal', $request->tanggal)
                ->where('rekap_modal.rekap_modal_m_area_id', $request->area)
                ->where('rekap_modal.rekap_modal_m_w_id', $request->waroeng)
                ->where('rekap_modal.rekap_modal_id', $get_modal_id->rekap_modal_id);

            if ($request->trans != 'all') {
                $garansi->where('m_transaksi_tipe.m_t_t_name', $request->trans);
            }

            $garansi = $garansi->selectRaw('max(rekap_garansi.rekap_garansi_qty) AS qty_gar,
                    max(rekap_garansi.rekap_garansi_reguler_price) as harga_garansi,
                    rekap_transaksi.r_t_tanggal as tanggal_gar,
                    rekap_garansi.rekap_garansi_m_produk_nama as menu_gar,
                    max(rekap_transaksi.r_t_m_w_nama) as waroeng_gar,
                    max(m_jenis_produk.m_jenis_produk_nama) as jenis_produk_gar,
                    max(m_transaksi_tipe.m_t_t_name) as tipe_gar,
                    rekap_modal.rekap_modal_sesi,
                    max(rekap_garansi.rekap_garansi_price) as r_t_detail_price,
                    SUM(rekap_garansi.rekap_garansi_nominal) AS nominal_nota,
                    SUM(rekap_garansi.rekap_garansi_price * rekap_garansi.rekap_garansi_qty) as trans,
                    SUM(rekap_garansi.rekap_garansi_nominal) - (SUM(rekap_garansi.rekap_garansi_reguler_price * rekap_garansi.rekap_garansi_qty)) cr_trans')
                ->groupBy('rekap_transaksi.r_t_tanggal',
                    'rekap_garansi.rekap_garansi_m_produk_nama',
                    'rekap_modal.rekap_modal_sesi',
                )
                ->orderBy('jenis_produk_gar', 'ASC')
                ->orderBy('menu_gar', 'ASC')->get();

            // return $garansi;
            // Query untuk data rekap transaksi
            $rekap = DB::table('rekap_transaksi_detail')
                ->leftJoin('rekap_transaksi', 'rekap_transaksi_detail.r_t_detail_r_t_id', '=', 'rekap_transaksi.r_t_id')
                ->leftJoin('m_produk', 'm_produk.m_produk_id', '=', 'rekap_transaksi_detail.r_t_detail_m_produk_id')
                ->leftJoin('m_jenis_produk', 'm_jenis_produk.m_jenis_produk_id', '=', 'm_produk.m_produk_m_jenis_produk_id')
                ->leftJoin('m_transaksi_tipe', 'm_transaksi_tipe.m_t_t_id', '=', 'rekap_transaksi.r_t_m_t_t_id')
                ->leftJoin('rekap_modal', 'rekap_modal.rekap_modal_id', '=', 'rekap_transaksi.r_t_rekap_modal_id')
                ->whereDate('rekap_modal.rekap_modal_tanggal', $request->tanggal)
                ->where('rekap_modal.rekap_modal_m_area_id', $request->area)
                ->where('rekap_modal.rekap_modal_m_w_id', $request->waroeng)
                ->where('rekap_modal.rekap_modal_id', $get_modal_id->rekap_modal_id);

            if ($request->trans != 'all') {
                $rekap->where('m_transaksi_tipe.m_t_t_name', $request->trans);
            }

            $rekap = $rekap->selectRaw('SUM(r_t_detail_qty) AS qty,
                    r_t_detail_reguler_price,
                    r_t_tanggal,
                    r_t_detail_m_produk_nama,
                    r_t_detail_m_produk_id,
                    r_t_m_w_nama as m_w_nama,
                    m_jenis_produk_id,
                    m_jenis_produk_nama,
                    m_t_t_name,
                    m_t_t_id,
                    rekap_modal_sesi,
                    r_t_detail_price,
                    SUM(r_t_detail_nominal) AS nominal_nota,
                    SUM(r_t_detail_price * r_t_detail_qty) as trans,
                    SUM(r_t_detail_nominal) - (SUM(r_t_detail_reguler_price * r_t_detail_qty)) cr_trans,
                    sum(r_t_detail_nominal_pajak) pajak,
                    r_t_detail_package_price as kemasan,
                    max(rekap_transaksi.r_t_status) r_t_status')
                ->groupBy('rekap_transaksi.r_t_tanggal', 'rekap_transaksi_detail.r_t_detail_m_produk_nama', 'rekap_transaksi_detail.r_t_detail_m_produk_id', 'rekap_transaksi.r_t_m_w_nama', 'rekap_transaksi_detail.r_t_detail_reguler_price', 'm_jenis_produk.m_jenis_produk_nama', 'm_jenis_produk.m_jenis_produk_id', 'm_transaksi_tipe.m_t_t_name', 'm_transaksi_tipe.m_t_t_id', 'rekap_modal.rekap_modal_sesi', 'rekap_transaksi_detail.r_t_detail_price', 'rekap_transaksi.r_t_id', 'rekap_transaksi_detail.r_t_detail_package_price')
                ->orderBy('m_jenis_produk.m_jenis_produk_id', 'ASC')
                ->orderBy('rekap_transaksi_detail.r_t_detail_m_produk_nama', 'ASC')->get();

            // Gabungkan hasil query
            // $result = $rekap->union($garansi)->get();

        } else {
            return response()->json(['messages' => 'Data pada tanggal ' . $request->tanggal . ' tidak ada', 'type' => 'error']);
        }

        $totalNominal = 0;
        $totalNominal_trans = 0;
        $totalSelisihTrans = 0;
        $totalCR = 0;
        $totalselisihCR = 0;
        $totalPajak = 0;
        $totalselisihTax = 0;
        $data = array();

        // foreach ($garansi as $key => $valGaransi) {
        //     // if ($val_menu->r_t_detail_m_produk_id == $valGaransi->rekap_garansi_m_produk_id && $val_menu->r_t_tanggal == $valGaransi->r_t_tanggal && $val_menu->m_t_t_id == $valGaransi->m_t_t_id && $val_menu->id == $valGaransi->id) {
        //     $nominal_garansi = $valGaransi->harga_garansi + $valGaransi->qty_gar;
        //     // $row[] = date('d-m-Y', strtotime($valGaransi->tanggal_gar));
        //     // $row[] = $valGaransi->waroeng_gar;
        //     $row[] = $valGaransi->menu_gar;
        //     $row[] = $valGaransi->qty_gar;
        //     $row[] = number_format($nominal_garansi);
        //     // $row[] = $valGaransi->jenis_produk_gar;
        //     // $row[] = $valGaransi->tipe_gar;
        //     // $pajakMenu = $pajakMenu + (($val_menu->r_t_detail_reguler_price * $valGaransi->qty) * 0.1);
        //     // return $valGaransi->menu_gar;
        //     // }
        // }

        // return $row;

        foreach ($garansi as $key => $valGaransi) {
            // if ($val_menu->r_t_tanggal == $valGaransi->tanggal_gar && $val_menu->id == $valGaransi->id) {
            $nominal_garansi = $valGaransi->harga_garansi + $valGaransi->qty_gar;
            $garansi_row = array();
            $garansi_row[] = date('d-m-Y', strtotime($valGaransi->tanggal_gar));
            $garansi_row[] = $valGaransi->waroeng_gar;
            $garansi_row[] = $valGaransi->menu_gar;
            $garansi_row[] = $valGaransi->qty_gar;
            $garansi_row[] = number_format($nominal_garansi);
            $garansi_row[] = $valGaransi->jenis_produk_gar;
            $garansi_row[] = $valGaransi->tipe_gar;
            $garansi_row[] = 'garansi';
            $garansi_row[] = '';
            $garansi_row[] = '';
            $garansi_row[] = '';
            $garansi_row[] = '';
            $garansi_row[] = '';
            $garansi_row[] = '';
            // $pajakMenu = $pajakMenu + (($val_menu->r_t_detail_reguler_price * $valGaransi->qty) * 0.1);
            // return $valGaransi->menu_gar;
            $data[] = $garansi_row;
            // }
        }
        foreach ($rekap as $key => $val_menu) {
            // $garansi = DB::table('rekap_garansi')
            //     ->leftJoin('rekap_transaksi', 'rekap_garansi_r_t_id', '=', 'r_t_id')
            //     ->leftJoin('m_produk', 'm_produk_id', '=', 'rekap_garansi_m_produk_id')
            //     ->leftJoin('m_jenis_produk', 'm_jenis_produk_id', '=', 'm_produk_m_jenis_produk_id')
            //     ->leftJoin('m_transaksi_tipe', 'm_t_t_id', '=', 'r_t_m_t_t_id')
            //     ->select(
            //         'rekap_garansi_r_t_id as id',
            //         'rekap_garansi_m_produk_nama as menu',
            //         'rekap_garansi_reguler_price as harga',
            //         'rekap_garansi_qty as qty',
            //         'm_jenis_produk_nama',
            //         'm_t_t_name'
            //     )
            //     ->where('rekap_garansi_r_t_id', $val_menu->id)
            //     ->first();

            // if (!empty($garansi) && $val_menu->id == $garansi->id) {
            //     $garansi_row[] = $garansi->menu;
            //     $garansi_row[] = $garansi->qty;
            //     $garansi_row[] = number_format($garansi->harga);
            //     $garansi_row[] = $garansi->m_jenis_produk_nama;
            //     $garansi_row[] = $garansi->m_t_t_name;

            //     $data[] = $row;
            //     $data[] = $garansi_row;
            // } else {
            $row = array();
            $row[] = date('d-m-Y', strtotime($val_menu->r_t_tanggal));
            $row[] = $val_menu->m_w_nama;
            $row[] = $val_menu->r_t_detail_m_produk_nama;
            $qty = $val_menu->qty;
            $pajakMenu = $val_menu->pajak;
            if (!empty($refund2)) {
                foreach ($refund as $key => $valRef) {
                    if ($val_menu->r_t_detail_m_produk_id == $valRef->r_r_detail_m_produk_id && $val_menu->r_t_tanggal == $valRef->r_r_tanggal && $val_menu->rekap_modal_sesi == $valRef->rekap_modal_sesi && $val_menu->m_t_t_name == $valRef->m_t_t_name) {
                        $qty = $val_menu->qty - $valRef->r_r_detail_qty;
                        $pajakMenu = $val_menu->pajak - (($val_menu->r_t_detail_reguler_price * $valRef->r_r_detail_qty) * 0.1);
                    }
                }
            }
            $nominal = $val_menu->r_t_detail_reguler_price * $qty + ($val_menu->kemasan * $qty);
            $crRef = $val_menu->r_t_detail_price * $qty + ($val_menu->kemasan * $qty);
            $row[] = $qty;
            $row[] = number_format($nominal);
            $row[] = $val_menu->m_jenis_produk_nama;
            $row[] = $val_menu->m_t_t_name;
            $nominal_trans = $val_menu->r_t_detail_price * $qty + ($val_menu->kemasan * $qty);
            $selisihTrans = $nominal - $nominal_trans;
            if ($val_menu->m_t_t_name != 'dine in' && $val_menu->m_t_t_name != 'take away') {
                if ($nominal == $nominal_trans) {
                    $selisihTrans = 'Harga Sama';
                } else {
                    $selisihTrans = 0;
                }
            }
            $row[] = number_format($nominal_trans);
            if (!is_string($selisihTrans)) {
                $row[] = number_format($selisihTrans);
            } else {
                $row[] = $selisihTrans;
            }
            $cr = $qty != 0 ? $crRef : 0;
            $row[] = number_format($cr);
            $selisihCR = $nominal - $cr;
            if ($val_menu->m_t_t_name != 'dine in' && $val_menu->m_t_t_name != 'take away') {
                $selisihCR = 0;
            }
            $row[] = number_format($selisihCR);
            $pajak = $nominal * 0.1;
            if ($val_menu->m_t_t_name != 'dine in' && $val_menu->m_t_t_name != 'take away') {
                $pajak = $nominal;
            }
            if ($val_menu->pajak == 0) {
                $pajak = 0;
            }
            $row[] = number_format($pajak);
            $selisihTax = $pajakMenu - $pajak;
            if ($val_menu->pajak == 0) {
                $selisihTax = 0;
            }
            $row[] = number_format($selisihTax);
            if ($request->status == 'all') {
                $data[] = $row;
            } elseif ($request->status == 'selisih' && $selisihTrans != 0 || $selisihCR != 0 || $selisihTax != 0) {
                $data[] = $row;
            }
            $totalNominal += $nominal;
            $totalNominal_trans += $nominal_trans;
            if (is_numeric($selisihTrans)) {
                $totalSelisihTrans += floatval($selisihTrans);
            }
            $totalCR += $cr;
            $totalselisihCR += $selisihCR;
            $totalPajak += $pajak;
            $totalselisihTax += $selisihTax;
        }
        // }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = 'Total';
        $totalRow[] = '';
        $totalRow[] = number_format($totalNominal);
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = number_format($totalNominal_trans);
        $totalRow[] = number_format($totalSelisihTrans);
        $totalRow[] = number_format($totalCR);
        $totalRow[] = number_format($totalselisihCR);
        $totalRow[] = number_format($totalPajak);
        $totalRow[] = number_format($totalselisihTax);
        if ($request->status == 'all') {
            $data[] = $totalRow;
        } elseif ($request->status == 'selisih' && $totalSelisihTrans != 0 || $totalselisihCR != 0 || $totalselisihTax != 0) {
            $data[] = $totalRow;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
}