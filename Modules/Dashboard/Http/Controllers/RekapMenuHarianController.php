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

        $refundM = DB::table('rekap_refund_detail')
            ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_r_rekap_modal_id')
            ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->where('rekap_modal_id', $get_modal_id->rekap_modal_id);
        $refund = $refundM->get();

        $refund2 = $refundM->first();

        $get = DB::table('rekap_transaksi_detail')
            ->leftJoin('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->leftJoin('m_w', 'm_w_id', 'r_t_m_w_id')
            ->leftJoin('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->leftJoin('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->leftJoin('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->leftJoin('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->whereDate('rekap_modal_tanggal', $request->tanggal)
            ->where('rekap_modal_m_area_id', $request->area)
            ->where('rekap_modal_m_w_id', $request->waroeng)
            ->where('rekap_modal_id', $get_modal_id->rekap_modal_id)
            ->where('r_t_detail_status', 'paid');
        if ($request->trans != 'all') {
            $get->where('m_t_t_name', $request->trans);
        }
        $get = $get->selectRaw('SUM(r_t_detail_qty) AS qty, r_t_detail_reguler_price, r_t_tanggal, r_t_detail_m_produk_nama, r_t_detail_m_produk_id, m_w_nama, m_jenis_produk_id, m_jenis_produk_nama, m_t_t_name, rekap_modal_sesi, r_t_detail_price, SUM(r_t_detail_nominal) AS nominal_nota, SUM(r_t_detail_price * r_t_detail_qty) as trans, SUM(r_t_detail_nominal) - (SUM(r_t_detail_reguler_price * r_t_detail_qty)) cr_trans, sum(r_t_detail_nominal_pajak) pajak')
            ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'r_t_detail_m_produk_id', 'm_w_nama', 'r_t_detail_reguler_price', 'm_jenis_produk_nama', 'm_jenis_produk_id', 'm_t_t_name', 'rekap_modal_sesi', 'r_t_detail_price')
            ->orderBy('m_jenis_produk_id', 'ASC')
            ->orderBy('r_t_detail_m_produk_nama', 'ASC')
            ->get();

        $totalNominal = 0;
        $totalNominal_trans = 0;
        $totalSelisihTrans = 0;
        $totalCR = 0;
        $totalselisihCR = 0;
        $totalPajak = 0;
        $totalPajakMenu = 0;
        $totalselisihTax = 0;
        $data = array();
        foreach ($get as $key => $val_menu) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($val_menu->r_t_tanggal));
            $row[] = $val_menu->m_w_nama;
            $row[] = $val_menu->r_t_detail_m_produk_nama;
            $crRef = $val_menu->nominal_nota;
            $qty = $val_menu->qty;
            $nominal = $val_menu->r_t_detail_reguler_price * $val_menu->qty;
            // $pajak = $nominal * 0.1;
            $pajakMenu = $val_menu->pajak;
            if (!empty($refund2)) {
                foreach ($refund as $key => $valRef) {
                    if ($val_menu->r_t_detail_m_produk_id == $valRef->r_r_detail_m_produk_id && $val_menu->r_t_tanggal == $valRef->r_r_tanggal && $val_menu->rekap_modal_sesi == $valRef->rekap_modal_sesi && $val_menu->m_t_t_name == $valRef->m_t_t_name) {
                        $qty = $val_menu->qty - $valRef->r_r_detail_qty;
                        $nominal = $val_menu->r_t_detail_reguler_price * $qty;
                        $crRef = $val_menu->nominal_nota - ($val_menu->r_t_detail_reguler_price * $valRef->r_r_detail_qty);
                        // $pajak = $nominal * 0.1;
                        $pajakMenu = $val_menu->pajak - (($val_menu->r_t_detail_reguler_price * $valRef->r_r_detail_qty) * 0.1);
                    }
                }
            }
            $row[] = $qty;
            $row[] = number_format($nominal);
            $row[] = $val_menu->m_jenis_produk_nama;
            $row[] = $val_menu->m_t_t_name;
            $nominal_trans = $val_menu->r_t_detail_price * $qty;
            if ($val_menu->m_t_t_name != 'dine in' && $val_menu->m_t_t_name != 'take away') {
                $nominal_trans = $nominal;
            }
            $selisihTrans = $nominal - $nominal_trans;
            $row[] = number_format($nominal_trans);
            $row[] = number_format($selisihTrans);
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
            // if ($val_menu->pajak == 0 || $qty == 0) {
            //     $pajak = 0;
            // }

            $row[] = number_format($pajak);
            $row[] = number_format($pajakMenu);
            $selisihTax = $pajak - $val_menu->pajak;
            if ($val_menu->pajak == 0 || $qty == 0) {
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
            $totalSelisihTrans += $selisihTrans;
            $totalCR += $cr;
            $totalselisihCR += $selisihCR;
            $totalPajak += $pajak;
            $totalPajakMenu += $val_menu->pajak;
            $totalselisihTax += $selisihTax;
        }
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
        $totalRow[] = number_format($totalPajakMenu);
        $totalRow[] = number_format($totalselisihTax);
        if ($request->status == 'all') {
            $data[] = $totalRow;
        } elseif ($request->status == 'selisih' && $totalSelisihTrans != 0 || $totalselisihCR != 0 || $totalselisihTax != 0) {
            $data[] = $totalRow;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    // function export_excel(Request $request) {
    // $tgl = tgl_indo($request->tanggal);
    // $w_nama = strtoupper($this->getNamaW($request->waroeng));
    // $nama_user = DB::table('users')->where('users_id',$request->opr)->get()->name();
    // $kacab = DB::table('history_jabatan')
    // ->where('history_jabatan_m_w_code',$request->waroeng)
    // ->first();
    // $kasir = DB::table('users')->where('users_id',$request->operator)->first()->name;
    // $shift = $request->sesi;
    //     return Excel::download(new UsersExport($request), 'Laporan Penjualan Menu.xlsx');
    // }
}
