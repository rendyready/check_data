<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Exports\RekapSelisihPenjualanExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RekapSelisihController extends Controller
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
        return view('dashboard::rekap_selisih', compact('data'));
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
        $modal = DB::table('rekap_modal')
            ->selectRaw('
                date(rekap_modal_tanggal) tanggal,
                rekap_modal_m_area_nama area,
                rekap_modal_m_w_nama waroeng,
                sum(rekap_modal_cash_real) real,
                sum(rekap_modal_nominal) nominal,
                sum(rekap_modal_cash_in) in,
                sum(rekap_modal_cash_out) out
                ')
            ->where('rekap_modal_status', 'close');
        if ($request->area != 'all') {
            $modal->where('rekap_modal_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $modal->where('rekap_modal_m_w_id', $request->waroeng);
            }
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $modal->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), [$start, $end]);
        } else {
            $modal->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        $modal = $modal->groupby('area', 'waroeng', 'tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $rekap = DB::table('rekap_transaksi')
            ->selectRaw('
                r_t_tanggal tanggal,
                r_t_m_area_nama area,
                r_t_m_w_nama waroeng,
                sum(r_t_nominal_free_kembalian) free,
                sum(r_t_nominal_pembulatan) bulat');
        if ($request->area != 'all') {
            $rekap->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $rekap->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $rekap->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $rekap->where('r_t_tanggal', $request->tanggal);
        }
        $rekap = $rekap->groupby('area', 'waroeng', 'tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $selisihPlus = 0;
        $selisihMinus = 0;
        $totalSelisihPlus = 0;
        $totalSelisihMinus = 0;
        $totalFreeKembalian = 0;
        $totalPembulatan = 0;
        $data = array();
        foreach ($modal as $valModal) {
            $row = array();
            $saldoAkhir = $valModal->nominal + $valModal->in - $valModal->out;
            $selisih = $valModal->real - $saldoAkhir;
            $row[] = $valModal->area;
            $row[] = $valModal->waroeng;
            $row[] = date('d-m-Y', strtotime($valModal->tanggal));
            if ($selisih < 0) {
                $selisihMinus = $selisih;
                $row[] = 0;
                $row[] = number_format($selisihMinus);
            } else {
                $selisihPlus = $selisih;
                $row[] = number_format($selisihPlus);
                $row[] = 0;
            }
            foreach ($rekap as $valRekap) {
                if ($valModal->tanggal == $valRekap->tanggal && $valModal->waroeng == $valRekap->waroeng) {
                    $row[] = number_format($valRekap->bulat);
                    $row[] = number_format($valRekap->free);
                    $totalFreeKembalian += $valRekap->free;
                    $totalPembulatan += $valRekap->bulat;
                }
            }
            $data[] = $row;
            $totalSelisihPlus += $selisihPlus;
            $totalSelisihMinus += $selisihMinus;
        }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '<b>Total</b>';
        $totalRow[] = '<b>' . number_format($totalSelisihPlus) . '</b>';
        $totalRow[] = '<b>' . number_format($totalSelisihMinus) . '</b>';
        $totalRow[] = '<b>' . number_format($totalPembulatan) . '</b>';
        $totalRow[] = '<b>' . number_format($totalFreeKembalian) . '</b>';

        $data[] = $totalRow;

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function export_excel(Request $request)
    {
        $modal = DB::table('rekap_modal')
            ->selectRaw('
                date(rekap_modal_tanggal) tanggal,
                rekap_modal_m_area_nama area,
                rekap_modal_m_w_nama waroeng,
                sum(rekap_modal_cash_real) real,
                sum(rekap_modal_nominal) nominal,
                sum(rekap_modal_cash_in) in,
                sum(rekap_modal_cash_out) out
                ')
            ->where('rekap_modal_status', 'close');
        if ($request->area != 'all') {
            $modal->where('rekap_modal_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $modal->where('rekap_modal_m_w_id', $request->waroeng);
            }
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $modal->whereBetween(DB::raw('DATE(rekap_modal_tanggal)'), [$start, $end]);
        } else {
            $modal->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal);
        }
        $modal = $modal->groupby('area', 'waroeng', 'tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $rekap = DB::table('rekap_transaksi')
            ->selectRaw('
                r_t_tanggal tanggal,
                r_t_m_area_nama area,
                r_t_m_w_nama waroeng,
                sum(r_t_nominal_free_kembalian) free,
                sum(r_t_nominal_pembulatan) bulat');
        if ($request->area != 'all') {
            $rekap->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $rekap->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $rekap->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $rekap->where('r_t_tanggal', $request->tanggal);
        }
        $rekap = $rekap->groupby('area', 'waroeng', 'tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $selisihPlus = 0;
        $selisihMinus = 0;
        $totalSelisihPlus = 0;
        $totalSelisihMinus = 0;
        $totalFreeKembalian = 0;
        $totalPembulatan = 0;
        $data = array();
        foreach ($modal as $valModal) {
            $row = array();
            $saldoAkhir = $valModal->nominal + $valModal->in - $valModal->out;
            $selisih = $valModal->real - $saldoAkhir;
            $row[] = $valModal->area;
            $row[] = $valModal->waroeng;
            $row[] = date('d-m-Y', strtotime($valModal->tanggal));
            if ($selisih < 0) {
                $selisihMinus = $selisih;
                $row[] = 0;
                $row[] = $selisihMinus;
            } else {
                $selisihPlus = $selisih;
                $row[] = $selisihPlus;
                $row[] = 0;
            }
            foreach ($rekap as $valRekap) {
                if ($valModal->tanggal == $valRekap->tanggal && $valModal->waroeng == $valRekap->waroeng) {
                    $row[] = $valRekap->bulat;
                    $row[] = $valRekap->free;
                    $totalFreeKembalian += $valRekap->free;
                    $totalPembulatan += $valRekap->bulat;
                }
            }
            $data[] = $row;
            $totalSelisihPlus += $selisihPlus;
            $totalSelisihMinus += $selisihMinus;
        }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = 'Total';
        $totalRow[] = $totalSelisihPlus;
        $totalRow[] = $totalSelisihMinus;
        $totalRow[] = $totalPembulatan;
        $totalRow[] = $totalFreeKembalian;

        $data[] = $totalRow;

        return Excel::download(new RekapSelisihPenjualanExport($data), 'Rekap Selisih, Pembulatan dan Free Kembalian - ' . $request->tanggal . '.xlsx');

        // $output = array("data" => $data);
        // return response()->json($output);
    }
}
