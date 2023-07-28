<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GaransiController extends Controller
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
        return view('dashboard::rekap_garansi', compact('data'));
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

    public function select_user(Request $request)
    {
        if ($request->id_waroeng != 'all') {
            $user = DB::table('rekap_garansi')
                ->join('users', 'rekap_garansi_created_by', 'users_id')
                ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
                ->select('users_id', 'name');
            if (in_array(Auth::user()->waroeng_id, $this->get_akses_area())) {
                $user->where('waroeng_id', $request->id_waroeng);
            } else {
                $user->where('waroeng_id', Auth::user()->waroeng_id);
            }
            if (strpos($request->tanggal, 'to') !== false) {
                [$start, $end] = explode('to', $request->tanggal);
                $user->whereBetween('r_t_tanggal', [$start, $end]);
            } else {
                $user->where('r_t_tanggal', $request->tanggal);
            }
            $user1 = $user->orderBy('users_id', 'asc')
                ->get();
            $data = array();
            foreach ($user1 as $val) {
                $data[$val->users_id] = [$val->name];
                $data['all'] = 'All Operator';
            }
            return response()->json($data);
        }
    }

    public function show(Request $request)
    {
        $get = DB::table('rekap_garansi')
            ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            ->join('users', 'users_id', 'rekap_garansi_created_by')
            ->join('rekap_modal', 'rekap_modal_id', 'r_t_rekap_modal_id')
            ->where('rekap_modal_status', 'close');
        if (strpos($request->tanggal, 'to') !== false) {
            $dates = explode('to', $request->tanggal);
            $get->whereBetween('r_t_tanggal', $dates);
        } else {
            $get->where('r_t_tanggal', $request->tanggal);
        }
        if ($request->area != 'all') {
            $get->where('r_t_m_area_id', $request->area);
            if ($request->waroeng != 'all') {
                $get->where('r_t_m_w_id', $request->waroeng);
                if ($request->operator != 'all') {
                    $get->where('rekap_garansi_created_by', $request->operator);
                }
            }
        }
        $get = $get->orderBy('r_t_tanggal', 'ASC')
            ->orderBy('r_t_nota_code', 'ASC')
            ->get();

        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = $value->r_t_m_area_nama;
            $row[] = $value->r_t_m_w_nama;
            $row[] = date('d-m-Y', strtotime($value->r_t_tanggal));
            $row[] = $value->r_t_nota_code;
            $row[] = $value->name;
            $row[] = $value->r_t_bigboss;
            $row[] = $value->rekap_garansi_m_produk_nama;
            $row[] = $value->rekap_garansi_qty;
            $row[] = number_format($value->rekap_garansi_price);
            $row[] = number_format($value->rekap_garansi_nominal);
            $row[] = $value->rekap_garansi_keterangan;
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
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
