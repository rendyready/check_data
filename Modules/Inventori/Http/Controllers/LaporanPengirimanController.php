<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class LaporanPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inventori::index');
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

    public function select_user(Request $request)
    {
        $user = DB::table('users')
        ->join('rekap_beli', 'rekap_beli_created_by', 'users_id')
        ->select('users_id', 'name');
        if(in_array(Auth::user()->waroeng_id, $this->get_akses_area())){
            $user->where('waroeng_id', $request->id_waroeng);
        } else {
            $user->where('waroeng_id', Auth::user()->waroeng_id);
        }
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to' ,$request->tanggal);
            $user->whereBetween('rekap_beli_tgl', [$start, $end]);
        } else {
            $user->where('rekap_beli_tgl', $request->tanggal);
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

    public function lap_detail()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
        $data->suplay_pusat = [1,2,3,5];
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->whereIn('m_w_id', [3,4])
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('inventori::lap_pengiriman_detail', compact('data'));
    }

    public function tampil_detail(Request $request)
    {
        $data = new \stdClass();
        $data->transaksi_rekap = DB::table('rekap_beli')
            ->join('users', 'users_id', 'rekap_beli_created_by')
            ->where('rekap_beli_m_w_id', $request->waroeng);
                if($request->pengadaan != 'all'){
                    $data->transaksi_rekap->where('rekap_beli_created_by', $request->pengadaan);
                }
                if (strpos($request->tanggal, 'to') !== false) {
                    $dates = explode('to' ,$request->tanggal);
                    $data->transaksi_rekap->whereBetween('rekap_beli_tgl', $dates);
                } else {
                    $data->transaksi_rekap->where('rekap_beli_tgl', $request->tanggal);
                }
            $data->transaksi_rekap2 = $data->transaksi_rekap->orderby('rekap_beli_tgl', 'ASC')
                ->orderby('rekap_beli_code', 'ASC')
                ->get();
        $data->detail_nota = DB::table('rekap_beli_detail')
            ->orderby('rekap_beli_detail_m_produk_nama', 'ASC')
            ->get();
       
        return response()->json($data);
    }

    public function lap_rekap()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('inventori::lap_pengiriman_rekap', compact('data'));
    }

    public function lap_harian()
    {
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->user = DB::table('users')
            ->orderby('id', 'ASC')
            ->get();
        return view('inventori::lap_pengiriman_harian', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('inventori::edit');
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
