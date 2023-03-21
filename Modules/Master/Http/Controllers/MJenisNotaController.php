<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Models\{
    MJenisNotum,
    MW,
    MTransaksiTipe,
    MMenuHarga,
    MProduk
};  

class MJenisNotaController extends Controller
{
    public function index()
    {
        $data['data'] = MJenisNotum::
            select('m_jenis_nota_id','m_w_id','m_w_nama','m_t_t_id','m_t_t_name')
            ->join('m_w', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftJoin('m_transaksi_tipe', 'm_jenis_nota_m_t_t_id', 'm_t_t_id')
            ->orderby('m_w_id','asc')
            ->orderby('m_t_t_name','asc')
            ->get();
        $data['listWaroeng'] = MW::all();
        $data['listTipeTransaksi'] = MTransaksiTipe::orderBy('m_t_t_group','desc')
                                    ->orderBy('m_t_t_name','asc')
                                    ->get();
        
        return view('master::setting_harga', $data);
    }

    public function store(Request $request)
    {
        // return response($request->all());
        // Cek
        $cek = MJenisNotum::where($request->only('m_jenis_nota_m_w_id','m_jenis_nota_m_t_t_id'));
        if (empty($request->m_jenis_nota_id)) {
            if ($cek->count() <= 0) {
                MJenisNotum::insert($request->only('m_jenis_nota_m_w_id','m_jenis_nota_m_t_t_id')+[
                    'm_jenis_nota_created_by' => Auth::user()->id,
                    'm_jenis_nota_id' => $this->getMasterId('m_jenis_nota')
                ]);
            }
        }else{
            if ($cek->count() == 1) {
                MJenisNotum::where('m_jenis_nota_id',$request->m_jenis_nota_id)
                ->update($request->only('m_jenis_nota_m_w_id','m_jenis_nota_m_t_t_id')+[
                    'm_jenis_nota_updated_by' => Auth::user()->id
                ]); 
            }
        }
        return Redirect::route('m_jenis_nota.index');
    }

    public function show($id)
    {
        return response(MJenisNotum::where('m_jenis_nota_id',$id)->first(),200);
    }

    public function showHarga($id)
    {
        return response(MMenuHarga::where('m_menu_harga_id',$id)->first(),200);
    }

    public function detailHarga($id)
    {
        $nota = MJenisNotum::where('m_jenis_nota_id',$id)->first();
        $info = MTransaksiTipe::where('m_t_t_id',$nota->m_jenis_nota_m_t_t_id)->first();
        $data['m_t_t_name'] = $info->m_t_t_name;
        $data['m_menu_harga_m_jenis_nota_id'] = $id;
        $data['data'] = MMenuHarga::
            join('m_produk','m_produk_id','=','m_menu_harga_m_produk_id')
            ->where('m_menu_harga_m_jenis_nota_id',$id)->get();
        $filterProduk = MMenuHarga::select('m_menu_harga_m_produk_id')
        ->where('m_menu_harga_m_jenis_nota_id',$id)->get();
        $filterProdukArr = [];
        foreach ($filterProduk as $key => $value) {
            array_push($filterProdukArr,$value->m_menu_harga_m_produk_id);
        }
        $data['listProduk'] = MProduk::where('m_produk_jual','ya')->get();
        // ->whereNotIn('m_produk_id',$filterProdukArr)->get();
        return view('master::setting_harga_detail', $data);
    }

    public function simpanHarga(Request $request)
    {
        // return $request->all();
        $cek = MMenuHarga::where($request->only('m_menu_harga_m_jenis_nota_id','m_menu_harga_m_produk_id'));
        if (empty($request->m_menu_harga_id)) {
            if ($cek->count() <=0) {
                MMenuHarga::insert($request->except('m_menu_harga_id','_token')+[
                    'm_menu_harga_created_by' => Auth::user()->id,
                    'm_menu_harga_id' => $this->getMasterId('m_menu_harga')
                ]);
            }
        }else{
            if ($cek->count() == 1) {
                MMenuHarga::where('m_menu_harga_id',$request->m_menu_harga_id)
                ->inser($request->except('m_menu_harga_id','_token')+[
                    'm_menu_harga_created_by' => Auth::user()->id
                ]);
            }
        }

        return Redirect::route('m_jenis_nota.detail_harga',$request->m_menu_harga_m_jenis_nota_id);
    }

}
