<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapWbdController extends Controller
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
        return view('dashboard::rekap_wbd', compact('data'));
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

    public function show_member(Request $request)
    {
        $wbdMember = DB::table('users')
            ->leftjoin('rekap_transaksi', DB::raw('CAST(r_t_member_id AS bigint)'), 'users_id')
            ->join('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
            ->leftjoin('m_produk', 'm_produk_id', 'r_t_detail_m_produk_id')
            ->selectRaw('
                    max(name) as name,
                    max(r_t_tanggal) as r_t_tanggal,
                    r_t_member_id,
                    sum(r_t_detail_nominal + r_t_detail_nominal_pajak + r_t_detail_nominal_sc) as nilaibeli
                ')
            ->whereRaw('LENGTH(r_t_member_id) = 5')
            ->where('m_produk_m_jenis_produk_id', '=', '11');
        if ($request->area != 'all') {
            if ($request->waroeng != 'all') {
                $wbdMember->where('waroeng_id', $request->waroeng);
            }
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $wbdMember->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $wbdMember->where('r_t_tanggal', $request->tanggal);
        }
        $wbdMember = $wbdMember->groupBy('r_t_member_id')
            ->orderby('nilaibeli', 'DESC')
            ->get()->toArray();

        $totalNilaibeli = 0;
        $counter = 1;
        foreach ($wbdMember as $key => $member) {
            $member->no = $counter;
            $totalNilaibeli += $member->nilaibeli;
            $counter++;
        }

        $wbdMember[] = (object) [
            'name' => '',
            'r_t_tanggal' => '',
            'r_t_member_id' => '',
            'no' => '<b>Total</b>',
            'nilaibeli' => number_format($totalNilaibeli, 2, '.', ''),
        ];

        $output = array("data" => $wbdMember);
        return response()->json($output);
    }

    public function detail_member(Request $request, $tanggal, $member)
    {
        $wbdDetail = DB::table('rekap_transaksi')
            ->selectRaw('name,
                    r_t_nota_code as nota,
                    r_t_tanggal as tanggal,
                    r_t_m_w_nama as waroeng,
                    r_t_detail_m_produk_nama as produk,
                    r_t_detail_qty as qty,
                    (r_t_detail_nominal + r_t_detail_nominal_pajak + r_t_detail_nominal_sc) as beli')
            ->where('m_produk_m_jenis_produk_id', '=', '11')
            ->join('users', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->join('rekap_transaksi_detail', 'r_t_id', '=', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', '=', 'm_produk_id')
            ->join('m_w', 'm_w_id', 'waroeng_id');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $wbdDetail->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $wbdDetail->where('r_t_tanggal', $request->tanggal);
        }
        $wbdDetail = $wbdDetail->where('users_id', $member)
            ->orderby('r_t_tanggal', 'ASC')
            ->get();

        $wrg = DB::table('users')
            ->join('m_w', 'm_w_id', 'waroeng_id')
            ->select('m_w_nama as waroeng', 'name')
            ->where('users_id', $member)
            ->first();

        $total = 0;
        $data = array();
        foreach ($wbdDetail as $wbd) {
            $row = array();
            $row[] = $wbd->nota;
            $row[] = $wbd->waroeng;
            $row[] = '<div class="text-center">' . $wbd->tanggal . '</div>';
            $row[] = $wbd->produk;
            $row[] = '<div class="text-center">' . $wbd->qty . '</div>';
            $row[] = '<div class="text-center">' . number_format($wbd->beli) . '</div>';
            $data[] = $row;
            $total += $wbd->beli;
        }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '<div class="text-center"><b> Total </b></div>';
        $totalRow[] = '<div class="text-center"><b>' . number_format($total) . '</b></div>';
        $data[] = $totalRow;

        $output = array(
            "data" => $data,
            "waroeng" => $wrg->waroeng,
            "member" => $wrg->name,
        );

        return response()->json($output);
    }

    public function show_waroeng(Request $request)
    {
        $wbdWaroeng = DB::table('rekap_transaksi')
            ->select('r_t_m_area_nama as area',
                'r_t_m_w_nama as waroeng',
                'r_t_tanggal as tanggal',
                'r_t_m_w_id as id_waroeng',
                DB::raw('SUM(r_t_detail_nominal - COALESCE(r_r_detail_nominal, 0)) AS total_nominal'),
                DB::raw('SUM(CASE WHEN LENGTH(r_t_member_id) = 5 THEN r_t_detail_nominal - COALESCE(r_r_detail_nominal, 0) ELSE 0 END) AS total_nominal_pegawai'))
            ->leftjoin('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
            ->leftJoin('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
            ->leftjoin('rekap_refund', 'r_t_id', 'r_r_r_t_id')
            ->leftJoin('rekap_refund_detail', 'r_r_id', 'r_r_detail_r_r_id')
            ->where('m_produk_m_jenis_produk_id', '11')
            ->when($request->area != 'all', function ($query) use ($request) {
                return $query->where('r_t_m_area_id', $request->area)
                    ->when($request->waroeng != 'all', function ($query) use ($request) {
                        return $query->where('r_t_m_w_id', $request->waroeng);
                    });
            })
            ->when(strpos($request->tanggal, 'to') !== false, function ($query) use ($request) {
                [$start, $end] = explode('to', $request->tanggal);
                return $query->whereBetween('r_t_tanggal', [$start, $end]);
            }, function ($query) use ($request) {
                return $query->where('r_t_tanggal', $request->tanggal);
            })
            ->groupBy('tanggal', 'area', 'waroeng', 'id_waroeng')
            ->get();

        $total_waroeng = 0;
        $total_member = 0;
        $data = array();
        foreach ($wbdWaroeng as $waroeng) {
            $row = array();
            $row[] = $waroeng->area;
            $row[] = $waroeng->waroeng;
            $row[] = $waroeng->tanggal;
            $row[] = number_format($waroeng->total_nominal);
            $row[] = number_format($waroeng->total_nominal_pegawai);
            $row[] = '<a id="button_detail_member" class="btn btn-sm button_detail_member btn-warning" data-tanggal="' . $waroeng->tanggal . '" data-waroeng="' . $waroeng->id_waroeng . '" title="Detail WBD karyawan"><i class="fas fa-eye"></i></a>';
            $data[] = $row;
            $total_waroeng += $waroeng->total_nominal;
            $total_member += $waroeng->total_nominal_pegawai;
        }
        // '<a id="button_detail_waroeng" class="btn btn-sm button_detail_waroeng btn-info" data-tanggal="' . $waroeng->tanggal . '" data-waroeng="' . $waroeng->waroeng_id . '" title="Detail WBD Omset"><i class="fas fa-eye"></i></a>
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '';
        $totalRow[] = '<div class="text-center"><b> Total </b></div>';
        $totalRow[] = '<div class="text-center"><b>' . number_format($total_waroeng) . '</b></div>';
        $totalRow[] = '<div class="text-center"><b>' . number_format($total_member) . '</b></div>';
        $totalRow[] = '';
        $data[] = $totalRow;

        $output = array("data" => $data);
        return response()->json($output);
    }

    // public function detail_waroeng($tanggal, $waroeng)
    // {
    //     // $refund = DB::table('rekap_refund_detail')
    //     //     ->join('rekap_refund', 'r_r_id', 'r_r_detail_r_r_id')
    //     //     ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
    //     //     ->join('m_produk', 'r_r_detail_m_produk_id', 'm_produk_id')
    //     //     ->where('r_r_tanggal', $tanggal)
    //     //     ->where('r_r_m_w_id', $waroeng)
    //     //     ->where('m_produk_m_jenis_produk_id', '11')
    //     //     ->get();

    //     // $detailWaroeng = DB::table('rekap_transaksi_detail')
    //     //     ->join('rekap_transaksi', 'r_t_id', 'r_t_detail_r_t_id')
    //     //     ->join('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
    //     //     ->selectRaw('r_t_nota_code as nota,
    //     //             r_t_detail_m_produk_nama as produk,
    //     //             sum(r_t_detail_qty) as qty,
    //     //             r_t_detail_reguler_price as harga,
    //     //             r_t_id,
    //     //             max(r_t_m_t_t_id) as r_t_m_t_t_id
    //     //         ')
    //     //     ->where('r_t_tanggal', $tanggal)
    //     //     ->where('r_t_m_w_id', $waroeng)
    //     //     ->where('m_produk_m_jenis_produk_id', '11')
    //     //     ->groupBy('nota', 'produk', 'harga', 'r_t_id')
    //     //     ->orderby('produk', 'ASC')
    //     //     ->get();

    //     // $tgl = DB::table('rekap_transaksi')
    //     //     ->select('r_t_tanggal as tanggal')
    //     //     ->where('r_t_tanggal', $tanggal)
    //     //     ->where('r_t_m_w_id', $waroeng)
    //     //     ->first();

    //     // $wrg = DB::table('rekap_transaksi')
    //     //     ->select('r_t_m_w_nama as waroeng')
    //     //     ->where('r_t_tanggal', $tanggal)
    //     //     ->where('r_t_m_w_id', $waroeng)
    //     //     ->first();

    //    $detailWaroeng = DB::table('rekap_transaksi')
    //         ->select('r_t_m_area_nama as area',
    //             'r_t_m_w_nama as waroeng',
    //             'r_t_tanggal as tanggal',
    //             'r_t_m_w_id as id_waroeng',
    //             DB::raw('SUM(r_t_detail_nominal - COALESCE(r_r_detail_nominal, 0)) AS total_nominal'))
    //         ->leftJoin('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
    //         ->leftjoin('rekap_refund', 'r_t_id', 'r_r_r_t_id')
    //         ->leftJoin('rekap_refund_detail', 'r_r_id', 'r_r_detail_r_r_id')
    //         ->where('m_produk_m_jenis_produk_id', '11')
    //         ->where('r_t_m_w_id', $waroeng)
    //         ->where('r_t_tanggal',$tanggal)
    //         ->where('LENGTH(r_t_member_id) = 5')
    //         ->get();
    //     $total = 0;
    //     $data = array();
    //     foreach ($detailWaroeng as $waroeng) {
    //         $qty = $waroeng->qty;
    //         if (!empty($refund)) {
    //             foreach ($refund as $wbdRefund) {
    //                 if ($waroeng->r_t_id == $wbdRefund->r_r_r_t_id && $waroeng->produk == $wbdRefund->r_r_detail_m_produk_nama && $waroeng->r_t_m_t_t_id == $wbdRefund->r_t_m_t_t_id) {
    //                     $qty = $qty - $wbdRefund->r_r_detail_qty;
    //                 }
    //             }
    //         }
    //         $nominal_wbd = $waroeng->harga * $qty;

    //         $row = array();
    //         $row[] = '<div class="text-center">' . $waroeng->nota . '</div>';
    //         $row[] = $waroeng->produk;
    //         $row[] = '<div class="text-center">' . $qty . '</div>';
    //         $row[] = '<div class="text-center">' . number_format($waroeng->harga) . '</div>';
    //         $row[] = '<div class="text-center">' . number_format($nominal_wbd) . '</div>';
    //         $data[] = $row;
    //         $total += $nominal_wbd;
    //     }
    //     $totalRow = array();
    //     $totalRow[] = '';
    //     $totalRow[] = '<div class="text-center"><b> Total </b></div>';
    //     $totalRow[] = '';
    //     $totalRow[] = '';
    //     $totalRow[] = '<div class="text-center"><b>' . number_format($total) . '</b></div>';
    //     $data[] = $totalRow;

    //     $output = array(
    //         "data" => $data,
    //         // "tanggal" => $tgl,
    //         // "waroeng" => $wrg,
    //     );
    //     return response()->json($output);
    // }

    public function detail_waroeng_member($tanggal, $waroeng)
    {
        $detailWaroeng = DB::table('rekap_transaksi')
            ->select(
                'name',
                'r_t_nota_code as nota',
                'r_t_tanggal as tanggal',
                'r_t_m_w_nama as r_t_m_w_nama',
                DB::raw('SUM(r_t_detail_nominal - COALESCE(r_r_detail_nominal, 0)) AS total_nominal'))
            ->join('users', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->leftjoin('rekap_transaksi_detail', 'r_t_detail_r_t_id', 'r_t_id')
            ->leftJoin('m_produk', 'r_t_detail_m_produk_id', 'm_produk_id')
            ->leftjoin('rekap_refund', 'r_t_id', 'r_r_r_t_id')
            ->leftJoin('rekap_refund_detail', 'r_r_id', 'r_r_detail_r_r_id')
            ->where('m_produk_m_jenis_produk_id', '11')
            ->where('r_t_m_w_id', $waroeng)
            ->where('r_t_tanggal', $tanggal)
            ->whereRaw('LENGTH(r_t_member_id) = 5')
            ->groupBy('name', 'nota', 'tanggal', 'r_t_m_w_nama')
            ->get();
        $total = 0;
        $data = array();
        foreach ($detailWaroeng as $waroeng) {
            $row = array();
            $row[] = $waroeng->name;
            $row[] = $waroeng->nota;
            $row[] = '<div class="text-center">' . number_format($waroeng->total_nominal) . '</div>';
            $data[] = $row;
            $total += $waroeng->total_nominal;
        }
        $totalRow = array();
        $totalRow[] = '';
        $totalRow[] = '<div class="text-center"><b> Total </b></div>';
        $totalRow[] = '<div class="text-center"><b>' . number_format($total) . '</b></div>';
        $data[] = $totalRow;

        $output = array(
            "data" => $data,
            "tanggal" => $tanggal,
            "waroeng" => $waroeng->r_t_m_w_nama,
        );
        return response()->json($output);
    }
}
