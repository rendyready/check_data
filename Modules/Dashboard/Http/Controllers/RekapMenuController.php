<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Exports\RekapMenuGlobalAktExport;
use App\Exports\RekapMenuGlobalExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RekapMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {

    }

    public function menu_summary()
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

        return view('dashboard::rekap_menu', compact('data'));
    }

    public function menu_global()
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
        $data->kategori = DB::table('m_jenis_produk')
            ->select('m_jenis_produk_id', 'm_jenis_produk_nama')
            ->orderBy('m_jenis_produk_id', 'asc')
            ->get();

        return view('dashboard::rekap_menu_global', compact('data'));
    }

    public function tanggal_rekap(Request $request)
    {
        $tanggal = DB::table('rekap_transaksi')
            ->select('r_t_tanggal');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $tanggal->whereBetween('r_t_tanggal', $dates);
        } else {
            $tanggal->where('r_t_tanggal', $request->tanggal);
        }
        $tanggal = $tanggal->orderBy('r_t_tanggal', 'asc')
            ->groupby('r_t_tanggal')
            ->get();

        $data = [];
        foreach ($tanggal as $val) {
            $data[] = $val->r_t_tanggal;
        }
        return response()->json($data);
    }

    public function select_waroeng(Request $request)
    {
        if ($request->id_area != 'all') {
            $waroeng = DB::table('m_w')
                ->select('m_w_id', 'm_w_nama', 'm_w_code');
            if ($request->id_area != 'all') {
                $waroeng->where('m_w_m_area_id', $request->id_area);
            }
            $waroeng = $waroeng->orderBy('m_w_id', 'asc')
                ->get();
            $data = array();
            foreach ($waroeng as $val) {
                $data[$val->m_w_id] = [$val->m_w_nama];
                $data['all'] = ['all waroeng'];
            }
            return response()->json($data);
        }
    }

    public function select_trans(Request $request)
    {
        if ($request->id_waroeng != 'all') {
            $trans = DB::table('m_transaksi_tipe')
                ->join('rekap_transaksi', 'r_t_m_t_t_id', 'm_t_t_id')
                ->select('m_t_t_id', 'm_t_t_name');
            if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
                if ($request->id_waroeng != 'all') {
                    $trans->where('r_t_m_w_id', $request->id_waroeng);
                }
            } else {
                if ($request->id_waroeng != 'all') {
                    $trans->where('r_t_m_w_id', Auth::user()->waroeng_id);
                }
            }
            $trans = $trans->orderBy('m_t_t_id', 'asc')
                ->get();

            $data = array();
            foreach ($trans as $val) {
                $data['all'] = ['all transaksi'];
                $data[$val->m_t_t_name] = [$val->m_t_t_name];
            }
            return response()->json($data);
        }
    }

    public function show(Request $request)
    {
        $tanggal1 = DB::table('rekap_transaksi')
            ->select('r_t_tanggal')
            ->orderBy('r_t_tanggal', 'asc')
            ->groupby('r_t_tanggal');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $tanggal1->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $tanggal1->where('r_t_tanggal', $request->tanggal);
        }
        $tanggal = $tanggal1->get();

        $get = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_w', 'm_w_id', 'r_t_m_w_id')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $get->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $get->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $get->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $get->where('r_t_m_w_id', $request->waroeng);
                if ($request->trans != 'all') {
                    $get->where('m_t_t_name', $request->trans);
                }
            }
        }

        $get2 = $get->selectRaw('sum(r_t_detail_qty) as qty, r_t_detail_reguler_price, r_t_tanggal, r_t_detail_m_produk_nama, m_w_nama, m_jenis_produk_id, m_jenis_produk_nama, m_t_t_name')
            ->groupBy('r_t_tanggal', 'r_t_detail_m_produk_nama', 'm_w_nama', 'r_t_detail_reguler_price', 'm_jenis_produk_nama', 'm_jenis_produk_id', 'm_t_t_name')
            ->orderby('m_jenis_produk_id', 'ASC')
            ->orderby('r_t_detail_m_produk_nama', 'ASC')
            ->get();
        $rows = [];
        foreach ($get2 as $key => $val_menu) {
            $waroeng = $val_menu->m_w_nama;
            $menu = $val_menu->r_t_detail_m_produk_nama;
            $date = $val_menu->r_t_tanggal;
            $qty = $val_menu->qty;
            if ($request->status == 'Export Excel') {
                $nominal = $val_menu->r_t_detail_reguler_price * $val_menu->qty;
            } else {
                $nominal = number_format($val_menu->r_t_detail_reguler_price * $val_menu->qty);

            }
            $kategori = $val_menu->m_jenis_produk_nama;
            $transaksi = $val_menu->m_t_t_name;
            if (!isset($rows[$waroeng])) {
                $rows[$waroeng] = [];
            }
            if (!isset($rows[$waroeng][$transaksi])) {
                $rows[$waroeng][$transaksi] = [];
            }
            if (!isset($rows[$waroeng][$transaksi][$kategori])) {
                $rows[$waroeng][$transaksi][$kategori] = [];
            }
            if (!isset($rows[$waroeng][$transaksi][$kategori][$menu])) {
                $rows[$waroeng][$transaksi][$kategori][$menu] = [];
            }
            if (!isset($rows[$waroeng][$transaksi][$kategori][$menu][$date])) {
                $rows[$waroeng][$transaksi][$kategori][$menu][$date] = [
                    'qty' => 0,
                    'nominal' => 0,
                ];
            }
            $rows[$waroeng][$transaksi][$kategori][$menu][$date]['qty'] += $qty;
            $rows[$waroeng][$transaksi][$kategori][$menu][$date]['nominal'] = $nominal;
        }

        $row = array();
        foreach ($rows as $waroeng => $kategoris) {
            foreach ($kategoris as $transaksi => $transaksis) {
                foreach ($transaksis as $kategori => $menus) {
                    foreach ($menus as $menu => $dates) {
                        $row = [
                            $waroeng,
                            $transaksi,
                            $kategori,
                            $menu,
                        ];
                        foreach ($tanggal as $date) {
                            $date_str = $date->r_t_tanggal;
                            if (isset($dates[$date_str])) {
                                $row[] = $dates[$date_str]['qty'];
                                $row[] = $dates[$date_str]['nominal'];
                            } else {
                                $row[] = 0;
                                $row[] = 0;
                            }
                        }
                        // $data['data'][] = $row;
                        $data[] = $row;
                    }
                }
            }
        }

        $mark = $request->status;
        $tanggal = $tanggal1->get()->pluck('r_t_tanggal')->toArray();

        if ($mark == 'Export Excel') {
            return Excel::download(new RekapMenuGlobalAktExport($data, $mark, $tanggal), 'Rekap Menu Summary - ' . $request->tanggal . '.xlsx');
        } else {
            $output = array(
                "data" => $data,
            );
            return response()->json($output);
        }
    }

    public function show_menu_global(Request $request)
    {
        $menu = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $menu->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $menu->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $menu->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $menu->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if ($request->kategori != 'all') {
            $menu->where('m_jenis_produk_id', $request->kategori);
        }
        $menu = $menu->selectRaw('
            sum(r_t_detail_qty) as qty,
            max(r_t_detail_reguler_price) as price,
            r_t_detail_m_produk_nama,
            m_jenis_produk_nama
        ')
            ->groupBy(
                'r_t_detail_m_produk_nama',
                'm_jenis_produk_nama'
            )
            ->orderby('r_t_detail_m_produk_nama', 'ASC')
            ->get();

        $data = array();
        foreach ($menu as $valMenu) {
            $row = array();
            $row[] = $valMenu->m_jenis_produk_nama;
            $row[] = $valMenu->r_t_detail_m_produk_nama;
            $row[] = number_format($valMenu->qty);
            $row[] = number_format($valMenu->price);
            $row[] = number_format($valMenu->qty * $valMenu->price);
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
        );
        return response()->json($output);
    }

    public function export_by_menu(Request $request)
    {
        // return $request->tanggal;
        $menu = DB::table('rekap_transaksi_detail')
            ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
            ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close')
            ->whereIn('m_w_m_w_jenis_id', [1, 2]);
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $menu->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $menu->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $menu->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $menu->where('r_t_m_w_id', $request->waroeng);
            }
        }
        if ($request->kategori != 'all') {
            $menu->where('m_jenis_produk_id', $request->kategori);
        }
        $menu = $menu->selectRaw('
            sum(r_t_detail_qty) as qty,
            r_t_detail_m_produk_nama,
            m_jenis_produk_nama
        ')
            ->groupBy(
                'r_t_detail_m_produk_nama',
                'm_jenis_produk_nama'
            )
            ->orderby('r_t_detail_m_produk_nama', 'ASC')
            ->get();

        $data = array();
        foreach ($menu as $valMenu) {
            $row = array();
            $row[] = $valMenu->m_jenis_produk_nama;
            $row[] = $valMenu->r_t_detail_m_produk_nama;
            $row[] = $valMenu->qty;
            $data[] = $row;
        }

        return Excel::download(new RekapMenuGlobalExport($data), 'Rekap Menu By Menu - ' . $request->tanggal . '.xlsx');
    }

    public function export_excel_akt(Request $request)
    {
        if ($request->mark == 'Export By Area') {
            $menu = DB::table('rekap_transaksi_detail')
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                ->where('rekap_modal_status', 'close')
                ->whereIn('m_w_m_w_jenis_id', [1, 2]);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $menu->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $menu->where('r_t_tanggal', $request->tanggal);
            }
            if ($request->area != 'all') {
                $menu->where('r_t_m_area_id', $request->area);
                if ($request->waroeng != 'all') {
                    $menu->where('r_t_m_w_id', $request->waroeng);
                }
            }
            if ($request->kategori != 'all') {
                $menu->where('m_jenis_produk_id', $request->kategori);
            }
            $menu = $menu->selectRaw('
                    r_t_m_area_id,
                    r_t_m_area_nama,
                    sum(r_t_detail_qty * r_t_detail_package_price) kemasan,
                    sum(r_t_detail_qty) as qty,
                    r_t_detail_reguler_price as price,
                    r_t_detail_m_produk_nama,
                    m_jenis_produk_nama
            ')
                ->groupBy(
                    'r_t_m_area_id',
                    'r_t_m_area_nama',
                    'r_t_detail_m_produk_nama',
                    'r_t_detail_reguler_price',
                    'm_jenis_produk_nama'
                )
                ->orderby('r_t_m_area_id', 'ASC')
                ->orderby('r_t_detail_m_produk_nama', 'ASC')
                ->get();

            $data = array();
            foreach ($menu as $valMenu) {
                $row = array();
                $row[] = $valMenu->r_t_m_area_nama;
                $row[] = $valMenu->m_jenis_produk_nama;
                $row[] = $valMenu->r_t_detail_m_produk_nama;
                $row[] = number_format($valMenu->qty);
                $row[] = number_format($valMenu->price);
                $row[] = number_format(($valMenu->qty * $valMenu->price) + $valMenu->kemasan);
                $data[] = $row;
            }

            $mark = $request->mark;

            return Excel::download(new RekapMenuGlobalAktExport($data, $mark), 'Rekap Menu By Area - ' . $request->tanggal . '.xlsx');

        } elseif ($request->mark == 'Export By Waroeng') {
            $menu = DB::table('rekap_transaksi_detail')
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->join('m_w', 'm_w_id', 'r_t_m_w_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                ->where('rekap_modal_status', 'close')
                ->whereIn('m_w_m_w_jenis_id', [1, 2]);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $menu->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $menu->where('r_t_tanggal', $request->tanggal);
            }
            if ($request->area != 'all') {
                $menu->where('r_t_m_area_id', $request->area);
                if ($request->waroeng != 'all') {
                    $menu->where('r_t_m_w_id', $request->waroeng);
                }
            }
            if ($request->kategori != 'all') {
                $menu->where('m_jenis_produk_id', $request->kategori);
            }
            $menu = $menu->selectRaw('
                    r_t_m_area_id,
                    r_t_m_area_nama,
                    r_t_m_w_id,
                    r_t_m_w_nama,
                    sum(r_t_detail_qty * r_t_detail_package_price) kemasan,
                    sum(r_t_detail_qty) as qty,
                    r_t_detail_reguler_price as price,
                    r_t_detail_m_produk_nama,
                    m_jenis_produk_nama
            ')
                ->groupBy(
                    'r_t_m_area_id',
                    'r_t_m_area_nama',
                    'r_t_m_w_id',
                    'r_t_m_w_nama',
                    'r_t_detail_m_produk_nama',
                    'r_t_detail_reguler_price',
                    'm_jenis_produk_nama'
                )
                ->orderby('r_t_m_area_id', 'ASC')
                ->orderby('r_t_m_area_nama', 'ASC')
                ->orderby('r_t_detail_m_produk_nama', 'ASC')
                ->get();

            $data = array();
            foreach ($menu as $valMenu) {
                $row = array();
                $row[] = $valMenu->r_t_m_area_nama;
                $row[] = $valMenu->r_t_m_w_nama;
                $row[] = $valMenu->m_jenis_produk_nama;
                $row[] = $valMenu->r_t_detail_m_produk_nama;
                $row[] = number_format($valMenu->qty);
                $row[] = number_format($valMenu->price);
                $row[] = number_format(($valMenu->qty * $valMenu->price) + $valMenu->kemasan);
                $data[] = $row;
            }

            $mark = $request->mark;

            return Excel::download(new RekapMenuGlobalAktExport($data, $mark), 'Rekap Menu By Waroeng - ' . $request->tanggal . '.xlsx');

        } elseif ($request->mark == 'Export By Tanggal') {

            $menu = DB::table('rekap_transaksi_detail')
                ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
                ->join('m_transaksi_tipe', 'm_t_t_id', 'r_t_m_t_t_id')
                ->join('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
                ->join('m_jenis_produk', 'm_jenis_produk_id', 'm_produk_m_jenis_produk_id')
                ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
                ->where('rekap_modal_status', 'close')
                ->whereIn('m_w_m_w_jenis_id', [1, 2]);
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $menu->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $menu->where('r_t_tanggal', $request->tanggal);
            }
            if ($request->area != 'all') {
                $menu->where('r_t_m_area_id', $request->area);
                if ($request->waroeng != 'all') {
                    $menu->where('r_t_m_w_id', $request->waroeng);
                }
            }
            if ($request->kategori != 'all') {
                $menu->where('m_jenis_produk_id', $request->kategori);
            }
            $menu = $menu->selectRaw('
                    r_t_m_area_id,
                    r_t_m_area_nama,
                    r_t_m_w_id,
                    r_t_m_w_nama,
                    r_t_tanggal,
                    m_t_t_name,
                    sum(r_t_detail_qty * r_t_detail_package_price) kemasan,
                    sum(r_t_detail_qty) as qty,
                    r_t_detail_reguler_price as price,
                    r_t_detail_m_produk_nama,
                    m_jenis_produk_nama
            ')
                ->groupBy(
                    'r_t_m_area_nama',
                    'r_t_m_area_id',
                    'r_t_m_w_nama',
                    'r_t_m_w_id',
                    'r_t_tanggal',
                    'm_t_t_name',
                    'r_t_detail_m_produk_nama',
                    'r_t_detail_reguler_price',
                    'm_jenis_produk_nama'
                )
                ->orderby('r_t_m_area_id', 'ASC')
                ->orderby('r_t_m_w_id', 'ASC')
                ->orderby('r_t_tanggal', 'ASC')
                ->orderby('m_t_t_name', 'ASC')
                ->orderby('r_t_detail_m_produk_nama', 'ASC')
                ->get();

            $data = array();
            foreach ($menu as $valMenu) {
                $row = array();
                $row[] = $valMenu->r_t_m_area_nama;
                $row[] = $valMenu->r_t_m_w_nama;
                $row[] = $valMenu->r_t_tanggal;
                $row[] = $valMenu->m_t_t_name;
                $row[] = $valMenu->m_jenis_produk_nama;
                $row[] = $valMenu->r_t_detail_m_produk_nama;
                $row[] = number_format($valMenu->qty);
                $row[] = number_format($valMenu->price);
                $row[] = number_format(($valMenu->qty * $valMenu->price) + $valMenu->kemasan);
                $data[] = $row;
            }

            $mark = $request->mark;

            return Excel::download(new RekapMenuGlobalAktExport($data, $mark), 'Rekap Menu By Tanggal - ' . $request->tanggal . '.xlsx');

        }

    }

}
