<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MJenisNotum;
use App\Models\MMenuHarga;
use App\Models\MProduk;
use App\Models\MTransaksiTipe;
use App\Models\MW;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MJenisNotaController extends Controller
{
    public function index()
    {
        $get_waroeng = DB::table('m_w')
            ->join('m_area', 'm_area_id', 'm_w_m_area_id')
            ->where('m_w_m_kode_nota', 'nota b')
            ->where('m_area_id', 5)
            ->get();

        $m_w_ids = $get_waroeng->pluck('m_w_id')->toArray();

        $get_list_nota = DB::table('m_jenis_nota')
            ->whereIn('m_jenis_nota_m_w_id', $m_w_ids)
            ->where('m_jenis_nota_m_t_t_id', 1)
            ->get();
        $nota_ids = $get_list_nota->pluck('m_jenis_nota_id')->toArray();

        $data['data'] = MJenisNotum::select('m_jenis_nota_id', 'm_w_id', 'm_w_nama', 'm_t_t_id', 'm_t_t_name')
            ->join('m_w', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftJoin('m_transaksi_tipe', 'm_jenis_nota_m_t_t_id', 'm_t_t_id')
            ->orderby('m_w_id', 'asc')
            ->orderby('m_t_t_name', 'asc')
            ->get();
        $data['listWaroeng'] = MW::all();
        $data['listTipeTransaksi'] = MTransaksiTipe::orderBy('m_t_t_group', 'desc')
            ->orderBy('m_t_t_name', 'asc')
            ->get();
        $data['area'] = DB::table('m_area')->get();
        $data['produk'] = DB::table('m_produk')->where('m_produk_m_klasifikasi_produk_id', 4)->get();
        return view('master::setting_harga', $data);
    }

    public function store(Request $request)
    {
        // return response($request->all());
        // Cek
        $cek = MJenisNotum::where($request->only('m_jenis_nota_m_w_id', 'm_jenis_nota_m_t_t_id'));
        if (empty($request->m_jenis_nota_id)) {
            if ($cek->count() <= 0) {
                MJenisNotum::insert($request->only('m_jenis_nota_m_w_id', 'm_jenis_nota_m_t_t_id') + [
                    'm_jenis_nota_created_by' => Auth::user()->users_id,
                    'm_jenis_nota_id' => $this->getMasterId('m_jenis_nota'),
                ]);
            }
        } else {
            if ($cek->count() == 1) {
                MJenisNotum::where('m_jenis_nota_id', $request->m_jenis_nota_id)
                    ->update($request->only('m_jenis_nota_m_w_id', 'm_jenis_nota_m_t_t_id') + [
                        'm_jenis_nota_updated_by' => Auth::user()->users_id,
                        'm_jenis_nota_status_sync' => 'send',
                    ]);
            }
        }
        return Redirect::route('m_jenis_nota.index');
    }

    public function copy_nota(Request $request)
    {
        $cek_duplicate = DB::table('m_jenis_nota')
            ->where('m_jenis_nota_m_w_id', $request->m_jenis_nota_waroeng_tujuan_id)
            ->where('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_trans_id_tujuan)->first();
        if (empty($cek_duplicate)) {
            DB::table('m_jenis_nota')->insert([
                'm_jenis_nota_id' => $this->getMasterId('m_jenis_nota'),
                'm_jenis_nota_m_w_id' => $request->m_jenis_nota_waroeng_tujuan_id,
                'm_jenis_nota_m_t_t_id' => $request->m_jenis_nota_trans_id_tujuan,
                'm_jenis_nota_created_by' => Auth::user()->users_id,
            ]);
            $last_nota_id = MJenisNotum::latest('m_jenis_nota_created_at')->first()->m_jenis_nota_id;
        } else {
            $last_nota_id = $cek_duplicate->m_jenis_nota_id;
        }
        $asal_nota_id = MJenisNotum::where('m_jenis_nota_m_w_id', $request->m_jenis_nota_waroeng_sumber_id)
            ->where('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_trans_id_asal)->first()->m_jenis_nota_id;
        $harga = MMenuHarga::where('m_menu_harga_m_jenis_nota_id', $asal_nota_id)->get();
        foreach ($harga as $key) {
            $cek = MMenuHarga::where('m_menu_harga_m_jenis_nota_id', $last_nota_id)
                ->where('m_menu_harga_m_produk_id', $key->m_menu_harga_m_produk_id)
                ->first();
            if (empty($cek)) {
                $data_harga = array(
                    'm_menu_harga_id' => $this->getMasterId('m_menu_harga'),
                    'm_menu_harga_nominal' => $key->m_menu_harga_nominal,
                    'm_menu_harga_m_jenis_nota_id' => $last_nota_id,
                    'm_menu_harga_m_produk_id' => $key->m_menu_harga_m_produk_id,
                    'm_menu_harga_status' => $key->m_menu_harga_status,
                    'm_menu_harga_tax_status' => $key->m_menu_harga_tax_status,
                    'm_menu_harga_sc_status' => $key->m_menu_harga_sc_status,
                    'm_menu_harga_status_sync' => 'send',
                    'm_menu_harga_created_by' => Auth::user()->users_id,
                );
                MMenuHarga::insert($data_harga);
            } else {
                $data_harga = array(
                    'm_menu_harga_nominal' => $key->m_menu_harga_nominal,
                    'm_menu_harga_m_jenis_nota_id' => $last_nota_id,
                    'm_menu_harga_m_produk_id' => $key->m_menu_harga_m_produk_id,
                    'm_menu_harga_status' => $key->m_menu_harga_status,
                    'm_menu_harga_tax_status' => $key->m_menu_harga_tax_status,
                    'm_menu_harga_sc_status' => $key->m_menu_harga_sc_status,
                    'm_menu_harga_status_sync' => 'send',
                    'm_menu_harga_client_target' => DB::raw('DEFAULT'),
                    'm_menu_harga_created_by' => Auth::user()->users_id,
                );
                MMenuHarga::where('m_menu_harga_id', $cek->m_menu_harga_id)->update($data_harga);
            }
        }
        return Redirect::route('m_jenis_nota.index');
    }
    public function update_harga(Request $request)
    {
        foreach ($request->nota_kode as $key => $value) {
            $get_waroeng = DB::table('m_w')
                ->join('m_area', 'm_area_id', 'm_w_m_area_id')
                ->where('m_w_m_kode_nota', $request->nota_kode[$key]);
            $area_id = ($request->m_area_id == 0) ? $get_waroeng->get() : $get_waroeng->where('m_area_id', $request->m_area_id)
                ->get();
            $m_w_ids = $get_waroeng->pluck('m_w_id')->toArray();
            foreach ($request->update_m_jenis_nota_trans_id as $m_t_t_id) {
                $get_list_nota = DB::table('m_jenis_nota')
                    ->whereIn('m_jenis_nota_m_w_id', $m_w_ids)
                    ->where('m_jenis_nota_m_t_t_id', $m_t_t_id)
                    ->get();

                foreach ($get_list_nota as $nota) {
                    $harga_menu = DB::table('m_menu_harga')
                        ->where('m_menu_harga_m_jenis_nota_id', $nota->m_jenis_nota_id)
                        ->where('m_menu_harga_m_produk_id', $request->m_produk_id)
                        ->first();

                    if ($harga_menu) {
                        DB::table('m_menu_harga')
                            ->where('m_menu_harga_id', $harga_menu->m_menu_harga_id)
                            ->update([
                                'm_menu_harga_nominal' => convertfloat($request->nom_harga[$key]),
                                'm_menu_harga_status' => $request->m_menu_harga_status,
                                'm_menu_harga_tax_status' => $request->m_menu_harga_tax_status,
                                'm_menu_harga_sc_status' => $request->m_menu_harga_sc_status,
                                'm_menu_harga_status_sync' => 'send'
                            ]);
                    } else {
                        DB::table('m_menu_harga')->insert([
                            'm_menu_harga_id' => $this->getMasterId('m_menu_harga'),
                            'm_menu_harga_m_jenis_nota_id' => $nota->m_jenis_nota_id,
                            'm_menu_harga_m_produk_id' => $request->m_produk_id,
                            'm_menu_harga_nominal' => convertfloat($request->nom_harga[$key]),
                            'm_menu_harga_status' => $request->m_menu_harga_status,
                            'm_menu_harga_tax_status' => $request->m_menu_harga_sc_status,
                            'm_menu_harga_sc_status' => $request->m_menu_harga_sc_status,
                            'm_menu_harga_created_by' => Auth::user()->users_id,
                        ]);
                    }
                }
            }
        }

        return response()->json(['type' => 'success','messages' => 'Update Harga Berhasil']);
    }

    public function show($id)
    {
        return response(MJenisNotum::where('m_jenis_nota_id', $id)->first(), 200);
    }

    public function showHarga($id)
    {
        return response(MMenuHarga::where('m_menu_harga_id', $id)->first(), 200);
    }

    public function detailHarga($id)
    {
        $nota = MJenisNotum::where('m_jenis_nota_id', $id)->first();
        $info = MTransaksiTipe::where('m_t_t_id', $nota->m_jenis_nota_m_t_t_id)->first();
        $data['m_t_t_name'] = $info->m_t_t_name;
        $data['m_menu_harga_m_jenis_nota_id'] = $id;
        $data['data'] = MMenuHarga::join('m_produk', 'm_produk_id', '=', 'm_menu_harga_m_produk_id')
            ->where('m_menu_harga_m_jenis_nota_id', $id)->orderBy('m_menu_harga_m_produk_id', 'asc')->get();
        $filterProduk = MMenuHarga::select('m_menu_harga_m_produk_id')
            ->where('m_menu_harga_m_jenis_nota_id', $id)->get();
        $filterProdukArr = [];
        foreach ($filterProduk as $key => $value) {
            array_push($filterProdukArr, $value->m_menu_harga_m_produk_id);
        }
        $data['listProduk'] = MProduk::where('m_produk_jual', 'ya')->get();
        // ->whereNotIn('m_produk_id',$filterProdukArr)->get();
        $data['jenis_produk'] = DB::table('m_jenis_produk')->get();
        $data['num'] = 1;
        $data['n'] = 1;
        $data['s'] = 1;
        return view('master::setting_harga_detail', $data);
    }

    public function simpanHarga(Request $request)
    {
        // return $request->all();
        $cek = MMenuHarga::where($request->only('m_menu_harga_m_jenis_nota_id', 'm_menu_harga_m_produk_id'));
        if (empty($request->m_menu_harga_id)) {
            if ($cek->count() <= 0) {
                MMenuHarga::insert($request->except('m_menu_harga_id', '_token') + [
                    'm_menu_harga_created_by' => Auth::user()->users_id,
                    'm_menu_harga_id' => $this->getMasterId('m_menu_harga'),
                ]);
            }
        } else {
            if ($cek->count() == 1) {
                MMenuHarga::where('m_menu_harga_id', $request->m_menu_harga_id)
                    ->update($request->except('m_menu_harga_id', '_token') + [
                        'm_menu_harga_created_by' => Auth::user()->users_id,
                        'm_menu_harga_status_sync' => 'send',
                    ]);
            }
        }

        return Redirect::route('m_jenis_nota.detail_harga', $request->m_menu_harga_m_jenis_nota_id);
    }

    public function simpanUpdateHarga(Request $request)
    {
        foreach ($request->m_menu_harga_id_edit as $key => $value) {
            DB::table('m_menu_harga')
                ->where('m_menu_harga_id', $request->m_menu_harga_id_edit[$key])
                ->update([
                    'm_menu_harga_nominal' => convertfloat($request->m_menu_harga_nominal_edit[$key]),
                    'm_menu_harga_status_sync' => 'send'
                ]);
        }
    }

    public function get_harga(Request $request)
    {
        // Query untuk nota A
        $queryNotaA = DB::table('m_jenis_nota')
            ->join('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->where('m_jenis_nota_m_w_id', 6)
            ->whereIn('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_trans_id)
            ->where('m_menu_harga_m_produk_id', $request->m_menu_id);

        // Query untuk nota B
        $queryNotaB = DB::table('m_jenis_nota')
            ->join('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->where('m_jenis_nota_m_w_id', 1)
            ->whereIn('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_trans_id)
            ->where('m_menu_harga_m_produk_id', $request->m_menu_id);

        // Ambil harga dari nota A
        $notaAHarga = $queryNotaA->pluck('m_menu_harga_nominal')->toArray();
        $data['nota_a_harga'] = implode(', ', $notaAHarga);

        // Ambil harga dari nota B
        $notaBHarga = $queryNotaB->pluck('m_menu_harga_nominal')->toArray();
        $data['nota_b_harga'] = implode(', ', $notaBHarga);

        return response()->json($data);
    }
}
