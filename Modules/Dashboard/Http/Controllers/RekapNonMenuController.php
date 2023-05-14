<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class RekapNonMenuController extends Controller
{
    
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
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

    public function show(Request $request)
    {
        $typeTransaksi = DB::table('m_transaksi_tipe')->get();
        $sesi = DB::table('rekap_modal')
                ->join('users','users_id','=','rekap_modal_created_by')
                ->where(DB::raw('DATE(rekap_modal_tanggal)'), $request->tanggal)
                ->where('rekap_modal_m_w_id', $request->waroeng)
                ->where('rekap_modal_status', 'close')
                ->orderBy('rekap_modal_sesi','asc')
                ->get();
        $getMenu = DB::table('m_produk')
                ->select('m_produk_id')
                ->whereNotIn('m_produk_m_jenis_produk_id',[9,11,12,13])->get();
        $listMenu = [];
        foreach ($getMenu as $key => $valMenu) {
            array_push($listMenu,$valMenu->m_produk_id);
        }
        $getNonMenu = DB::table('m_produk')
                ->select('m_produk_id')
                ->whereIn('m_produk_m_jenis_produk_id',[9])->get();
        $listNonMenu = [];
        foreach ($getNonMenu as $key => $valMenu) {
            array_push($listNonMenu,$valMenu->m_produk_id);
        }
        $getKbd = DB::table('m_produk')
                ->select('m_produk_id')
                ->whereIn('m_produk_m_jenis_produk_id',[11])->get();
        $listKbd = [];
        foreach ($getKbd as $key => $valMenu) {
            array_push($listKbd,$valMenu->m_produk_id);
        }
 
        $getIceCream = DB::table('m_produk')
                ->join('config_sub_jenis_produk','config_sub_jenis_produk_m_produk_id','=','m_produk_id')
                ->select('m_produk_id')
                ->whereIn('config_sub_jenis_produk_m_sub_jenis_produk_id',[20,22,23,24,25])->get();
        $listIceCream = [];
        foreach ($getIceCream as $key => $valMenu) {
            array_push($listIceCream,$valMenu->m_produk_id);
        }
        // return $listIceCream;
        $sales = [];
        foreach ($sesi as $key => $valSesi) {
            foreach ($typeTransaksi as $key => $valType) {
                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Tipe'] = $valType->m_t_t_name;
                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Menu'] = 0;
                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Non Menu'] = 0;
                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Ice Cream'] = 0;
                $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['KBD'] = 0;
                #Menu
                $menu = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id',$listMenu)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                if (!empty($menu)) {
                    $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Menu'] = number_format($menu->nominal);
                }
 
                #Non-Menu
                $nonMenu = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id',$listNonMenu)
                        ->whereNotIn('r_t_detail_m_produk_id',$listKbd)
                        ->whereNotIn('r_t_detail_m_produk_id',$listIceCream)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                if (!empty($nonMenu)) {
                    $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Non Menu'] = number_format($nonMenu->nominal);
                }
 
                #Ice-Cream
                $iceCream = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id',$listIceCream)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                if (!empty($iceCream)) {
                    $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['Ice Cream'] = number_format($iceCream->nominal);
                }
 
                #KBD
                $kbd = DB::table('rekap_transaksi')
                        ->join('rekap_transaksi_detail','r_t_detail_r_t_id','r_t_id')
                        ->selectRaw('r_t_rekap_modal_id, sum(r_t_detail_reguler_price*r_t_detail_qty) nominal')
                        ->where([
                            'r_t_rekap_modal_id' => $valSesi->rekap_modal_id,
                            'r_t_m_t_t_id' => $valType->m_t_t_id
                        ])
                        ->whereIn('r_t_detail_m_produk_id',$listKbd)
                        ->groupBy('r_t_rekap_modal_id')
                        ->first();
                if (!empty($kbd)) {
                    $sales[$valSesi->name." - Sesi {$valSesi->rekap_modal_sesi}"][$valType->m_t_t_id]['KBD'] = number_format($kbd->nominal);
                }
                $sales = [];
                        foreach ($sales as $row) {
                            $sales[] = array_values($row);
                        }
            $output = array("data" => $sales);
                }
            }
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
