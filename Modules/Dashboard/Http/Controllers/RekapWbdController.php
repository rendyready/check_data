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
            ->join('rekap_transaksi', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->join('rekap_transaksi_detail', 'r_t_id', '=', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_code', '=', 'm_produk_code')
            ->join('m_w', 'm_w_id', 'waroeng_id')
            ->selectRaw('
                    max(name) as name,
                    max(email) as email,
                    max(r_t_member_id) as r_t_member_id,
                    max(m_w_nama) as m_w_nama,
                    r_t_tanggal,
                    sum(r_t_detail_nominal + r_t_detail_nominal_pajak + r_t_detail_nominal_sc) as nilaibeli
                ')
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
        $wbdMember = $wbdMember->groupBy('r_t_tanggal')
            ->orderby('r_t_tanggal', 'ASC')
            ->get()->toArray();

        $output = array("data" => $wbdMember);
        return response()->json($output);
    }

    public function detail_member($tanggal, $member)
    {
        $wbdDetail = DB::table('rekap_transaksi')
            ->selectRaw('name,
                    email as email,
                    r_t_member_id as r_t_member_id,
                    r_t_nota_code as r_t_nota_code,
                    r_t_tanggal,
                    m_w_nama,
                    r_t_jam as r_t_jam,
                    r_t_m_area_nama as r_t_m_area_nama,
                    r_t_m_w_nama as r_t_m_w_nama,
                    r_t_detail_m_produk_nama as r_t_detail_m_produk_nama,
                    r_t_detail_qty,
                    (r_t_detail_nominal + r_t_detail_nominal_pajak + r_t_detail_nominal_sc) as nilaibeli')
            ->where('m_produk_m_jenis_produk_id', '=', '11')
            ->join('users', function ($join) {
                $join->on('users_id', '=', DB::raw('CAST(r_t_member_id AS bigint)'))
                    ->whereRaw('LENGTH(r_t_member_id) = 5');
            })
            ->join('rekap_transaksi_detail', 'r_t_id', '=', 'r_t_detail_r_t_id')
            ->join('m_produk', 'r_t_detail_m_produk_id', '=', 'm_produk_id')
            ->join('m_w', 'm_w_id', 'waroeng_id')
            ->where('r_t_tanggal', $tanggal)
            ->where('users_id', $member)
            ->orderby('r_t_tanggal', 'ASC')
            ->get()->toArray();

        $output = array("data" => $wbdDetail);
        return response()->json($output);
    }

    public function show_waroeng(Request $request)
    {

    }
}
