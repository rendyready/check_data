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
        $data['data'] = MJenisNotum::select('m_jenis_nota_id', 'm_w_id', 'm_w_nama', 'm_t_t_id', 'm_t_t_name', 'm_w_m_kode_nota')
            ->join('m_w', 'm_jenis_nota_m_w_id', 'm_w_id')
            ->leftJoin('m_transaksi_tipe', 'm_jenis_nota_m_t_t_id', 'm_t_t_id')
            ->whereNotIn('m_t_t_id', [2])
            ->orderby('m_w_id', 'asc')
            ->orderby('m_t_t_name', 'asc')
            ->get();
        $data['listWaroeng'] = MW::all();
        $data['listWaroengSumber'] = MW::whereIn('m_w_id',['119','120'])->get();
        $data['listTipeTransaksi'] = MTransaksiTipe::orderBy('m_t_t_group', 'desc')
            ->whereNotIn('m_t_t_id', [2])
            ->orderBy('m_t_t_name', 'asc')
            ->get();
        $data['area'] = DB::table('m_area')->get();
        $data['produk'] = DB::table('m_produk')->where('m_produk_m_klasifikasi_produk_id', 4)->get();
        $data['m_tipe_nota'] = DB::table('m_tipe_nota')->orderBy('m_tipe_nota_id', 'asc')->get();
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
                    // 'm_jenis_nota_id' => $this->getMasterId('m_jenis_nota'),
                    'm_jenis_nota_id' => '1',
                ]);
            }
        } else {
            if ($cek->count() == 1) {
                MJenisNotum::where('m_jenis_nota_id', $request->m_jenis_nota_id)
                    ->update($request->only('m_jenis_nota_m_w_id', 'm_jenis_nota_m_t_t_id') + [
                        'm_jenis_nota_updated_by' => Auth::user()->users_id,
                        'm_jenis_nota_status_sync' => 'send',
                        'm_jenis_nota_client_target' => DB::raw('DEFAULT'),
                    ]);
            }
        }
        return Redirect::route('m_jenis_nota.index');
    }

    public function copy_nota(Request $request)
    {
        $trans_id_tujuan = $request->m_jenis_nota_trans_id_tujuan;
        $trans_id_tujuan = ($trans_id_tujuan == 1) ? [1, 2] : [$trans_id_tujuan];
        $created_at = Carbon::now();
        $user_id = Auth::user()->users_id;
        $cek_duplicate = DB::table('m_jenis_nota')
            ->where('m_jenis_nota_m_w_id', $request->m_jenis_nota_waroeng_tujuan_id)
            ->whereIn('m_jenis_nota_m_t_t_id', $trans_id_tujuan)
            ->get();

        if ($cek_duplicate->isEmpty()) {
            $last_nota_ids = [];
            foreach ($trans_id_tujuan as $trans_id) {
                // $last_nota_id = $this->getMasterId('m_jenis_nota');
                $data = [
                    'm_jenis_nota_id' => '1',
                    'm_jenis_nota_m_w_id' => $request->m_jenis_nota_waroeng_tujuan_id,
                    'm_jenis_nota_m_t_t_id' => $trans_id,
                    'm_jenis_nota_created_by' => $user_id,
                ];
                $id = DB::table('m_jenis_nota')->insertGetId($data);
                $last_nota_ids[] = $id;
            }
        } else {
            $last_nota_ids = $cek_duplicate->pluck('m_jenis_nota_id')->toArray();
        }

        $asal_nota_id = MJenisNotum::where('m_jenis_nota_m_w_id', $request->m_jenis_nota_waroeng_sumber_id)
            ->where('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_trans_id_asal)
            ->first()->m_jenis_nota_id;

        $harga = MMenuHarga::where('m_menu_harga_m_jenis_nota_id', $asal_nota_id)->get();
        foreach ($harga as $key) {
            foreach ($last_nota_ids as $last_nota_id) {
                $cek = MMenuHarga::where('m_menu_harga_m_jenis_nota_id', $last_nota_id)
                    ->where('m_menu_harga_m_produk_id', $key->m_menu_harga_m_produk_id)
                    ->first();

                if (empty($cek)) {
                    $hargaData = [
                        // 'm_menu_harga_id' => $this->getMasterId('m_menu_harga'),
                        'm_menu_harga_id' => '1',
                        'm_menu_harga_nominal' => $key->m_menu_harga_nominal,
                        'm_menu_harga_m_jenis_nota_id' => $last_nota_id,
                        'm_menu_harga_m_produk_id' => $key->m_menu_harga_m_produk_id,
                        'm_menu_harga_status' => $key->m_menu_harga_status,
                        'm_menu_harga_tax_status' => $key->m_menu_harga_tax_status,
                        'm_menu_harga_sc_status' => $key->m_menu_harga_sc_status,
                        'm_menu_harga_status_sync' => 'send',
                        'm_menu_harga_created_by' => $user_id,
                    ];

                    MMenuHarga::insert($hargaData);
                } else {
                    $data_harga = [
                        'm_menu_harga_nominal' => $key->m_menu_harga_nominal,
                        'm_menu_harga_m_jenis_nota_id' => $last_nota_id,
                        'm_menu_harga_m_produk_id' => $key->m_menu_harga_m_produk_id,
                        'm_menu_harga_status' => $key->m_menu_harga_status,
                        'm_menu_harga_tax_status' => $key->m_menu_harga_tax_status,
                        'm_menu_harga_sc_status' => $key->m_menu_harga_sc_status,
                        'm_menu_harga_status_sync' => 'send',
                        'm_menu_harga_client_target' => DB::raw('DEFAULT'),
                        'm_menu_harga_updated_by' => $user_id,
                        'm_menu_harga_updated_at' => $created_at,
                    ];

                    MMenuHarga::where('m_menu_harga_id', $cek->m_menu_harga_id)->update($data_harga);
                }
            }
        }

        return Redirect::route('m_jenis_nota.index');
    }

    public function update_harga(Request $request)
    {
        $user = Auth::user();
        $notaKode = $request->m_tipe_nota;
        $mAreaId = ($request->m_area_id == 0) ? null : $request->m_area_id;
        $time = Carbon::now();
        foreach ($notaKode as $key => $kode) {
            $getWaroeng = DB::table('m_w')
                ->where('m_w_m_kode_nota', $kode)
                ->when($mAreaId, function ($query) use ($mAreaId) {
                    return $query->join('m_area', 'm_area_id', 'm_w_m_area_id')
                        ->where('m_area_id', $mAreaId);
                })
                ->get();

            $mWIds = $getWaroeng->pluck('m_w_id')->toArray();
            foreach ($request->update_m_jenis_nota_trans_id as $mTTId) {
                $getListaNota = DB::table('m_jenis_nota')
                    ->whereIn('m_jenis_nota_m_w_id', $mWIds)
                    ->when($mTTId == 1, function ($query) {
                        return $query->whereIn('m_jenis_nota_m_t_t_id', [1, 2]);
                    })
                    ->when($mTTId != 1, function ($query) use ($mTTId) {
                        return $query->where('m_jenis_nota_m_t_t_id', $mTTId);
                    })
                    ->get();

                foreach ($getListaNota as $nota) {
                    $hargaMenu = DB::table('m_menu_harga')
                        ->where('m_menu_harga_m_jenis_nota_id', $nota->m_jenis_nota_id)
                        ->where('m_menu_harga_m_produk_id', $request->m_produk_id)
                        ->first();

                    $data = [
                        'm_menu_harga_updated_at' => $time,
                        'm_menu_harga_updated_by' => $user->users_id,
                        'm_menu_harga_client_target' => DB::raw('DEFAULT'),
                    ];

                    if ($request->action == 'status_menu') {
                        $data['m_menu_harga_status'] = $request->m_menu_harga_status;
                        $data['m_menu_harga_tax_status'] = $request->m_menu_harga_tax_status;
                        $data['m_menu_harga_sc_status'] = $request->m_menu_harga_sc_status;
                    } else {
                        $data['m_menu_harga_nominal'] = convertfloat($request->nom_harga[$key]);
                        $data['m_menu_harga_status_sync'] = 'send';
                    }

                    if (isset($hargaMenu)) {
                        DB::table('m_menu_harga')
                            ->when($request->action == 'status_menu', function ($query) use ($hargaMenu) {
                                return $query->where('m_menu_harga_m_produk_id', $hargaMenu->m_menu_harga_m_produk_id)
                                    ->where('m_menu_harga_m_jenis_nota_id', $hargaMenu->m_menu_harga_m_jenis_nota_id);
                            })
                            ->when($request->action != 'status_menu', function ($query) use ($hargaMenu) {
                                return $query->where('m_menu_harga_id', $hargaMenu->m_menu_harga_id);
                            })
                            ->update($data);
                    } else {
                        if ($request->action == 'status_menu') {
                            return response()->json(['type' => 'danger', 'messages' => 'Menu Belum Ditambahkan ke Nota']);
                        } else {
                            // $data['m_menu_harga_id'] = $this->getMasterId('m_menu_harga');
                            $data['m_menu_harga_id'] = '1';
                            $data['m_menu_harga_m_jenis_nota_id'] = $nota->m_jenis_nota_id;
                            $data['m_menu_harga_m_produk_id'] = $request->m_produk_id;
                            $data['m_menu_harga_status'] = 1;
                            $data['m_menu_harga_tax_status'] = 1;
                            $data['m_menu_harga_created_by'] = $user->users_id;
                            $data['m_menu_harga_created_at'] = $time;
                            $data['m_menu_harga_client_target'] = DB::raw('DEFAULT');
                            DB::table('m_menu_harga')->insert($data);
                        }
                    }
                }
            }
        }
        return response()->json(['type' => 'success', 'messages' => 'Update Harga Berhasil']);
    }

    public function show($id)
    {
        return response(MJenisNotum::where('m_jenis_nota_id', $id)->first(), 200);
    }

    public function showHarga($id)
    {
        return response(MMenuHarga::
                join('m_jenis_nota', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
                ->where('m_menu_harga_id', $id)->orderBy('m_menu_harga_m_produk_id', 'asc')
                ->select('m_jenis_nota_id', 'm_jenis_nota_m_t_t_id', 'm_jenis_nota_m_w_id',
                    'm_menu_harga_id', 'm_menu_harga_m_produk_id', 'm_menu_harga_nominal', 'm_menu_harga_sc_status',
                    'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_menu_harga_m_jenis_nota_id')
                ->first(), 200);
    }

    public function detailHarga($id)
    {
        $nota = MJenisNotum::where('m_jenis_nota_id', $id)->first();
        $info = MTransaksiTipe::where('m_t_t_id', $nota->m_jenis_nota_m_t_t_id)->first();
        $data['m_t_t_name'] = $info->m_t_t_name;
        $data['m_menu_harga_m_jenis_nota_id'] = $id;
        $data['data'] = MMenuHarga::join('m_produk', 'm_produk_id', 'm_menu_harga_m_produk_id')
            ->join('m_jenis_nota', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
            ->where('m_menu_harga_m_jenis_nota_id', $id)->orderBy('m_menu_harga_m_produk_id', 'asc')
            ->select('m_produk_nama', 'm_produk_m_jenis_produk_id', 'm_produk_code',
                'm_menu_harga_id', 'm_menu_harga_nominal',
                'm_jenis_nota_m_w_id', 'm_jenis_nota_m_t_t_id',
                'm_menu_harga_status', 'm_menu_harga_tax_status', 'm_menu_harga_sc_status', 'm_produk_id')
            ->get();
        $filterProduk = MMenuHarga::select('m_menu_harga_m_produk_id')
            ->where('m_menu_harga_m_jenis_nota_id', $id)->get();
        $filterProdukArr = [];
        foreach ($filterProduk as $key => $value) {
            array_push($filterProdukArr, $value->m_menu_harga_m_produk_id);
        }
        $data['listProduk'] = MProduk::where('m_produk_jual', 'ya')->get();
        // ->whereNotIn('m_produk_id',$filterProdukArr)->get();
        $data['jenis_produk'] = DB::table('m_jenis_produk')
            ->whereNotIn('m_jenis_produk_id', [12, 13])
            ->orderBy('m_jenis_produk_id', 'asc')
            ->get();
        $data['num'] = 1;
        $data['n'] = 1;
        $data['s'] = 1;
        return view('master::setting_harga_detail', $data);
    }

    public function simpanHarga(Request $request)
    {
        $get_nota = DB::table('m_jenis_nota')
            ->whereIn('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_m_t_t_id == 1 ? [1, 2] : [$request->m_jenis_nota_m_t_t_id])
            ->where('m_jenis_nota_m_w_id', $request->m_jenis_nota_m_w_id)
            ->get();

        foreach ($get_nota as $key) {
            MMenuHarga::where('m_menu_harga_m_jenis_nota_id', $key->m_jenis_nota_id)
                ->where('m_menu_harga_m_produk_id', $request->m_menu_harga_m_produk_id)
                ->update([
                    'm_menu_harga_sc_status' => $request->m_menu_harga_sc_status,
                    'm_menu_harga_status' => $request->m_menu_harga_status,
                    'm_menu_harga_tax_status' => $request->m_menu_harga_tax_status,
                    'm_menu_harga_status_sync' => 'send',
                    'm_menu_harga_updated_at' => Carbon::now(),
                    'm_menu_harga_updated_by' => Auth::user()->users_id,
                    'm_menu_harga_client_target' => DB::raw('DEFAULT'),
                ]);
        }

        return Redirect::route('m_jenis_nota.detail_harga', $request->m_menu_harga_m_jenis_nota_id);
    }

    public function simpanUpdateHarga(Request $request)
    {
        foreach ($request->m_menu_harga_id_edit as $key => $value) {
            $updateData = [
                'm_menu_harga_nominal' => convertfloat($request->m_menu_harga_nominal_edit[$key]),
                'm_menu_harga_status_sync' => 'send',
                'm_menu_harga_updated_at' => Carbon::now(),
                'm_menu_harga_updated_by' => Auth::user()->users_id,
                'm_menu_harga_client_target' => DB::raw('DEFAULT'),
            ];

            if ($request->m_t_t_id[$key] == 1) {
                $get_jenis_nota_id = DB::table('m_jenis_nota')
                    ->where('m_jenis_nota_m_t_t_id', 2)
                    ->where('m_jenis_nota_m_w_id', $request->m_w_id[$key])
                    ->value('m_jenis_nota_id');

                if ($get_jenis_nota_id) {
                    DB::table('m_menu_harga')
                        ->where('m_menu_harga_m_jenis_nota_id', $get_jenis_nota_id)
                        ->where('m_menu_harga_m_produk_id', $request->m_produk_id[$key])
                        ->update($updateData);
                }
            }

            DB::table('m_menu_harga')
                ->where('m_menu_harga_id', $request->m_menu_harga_id_edit[$key])
                ->update($updateData);
        }
    }

    public function get_harga(Request $request)
    {
        $data = [];
        if ($request->get_tipe == 'get_harga') {
            foreach ($request->m_tipe_nota as $key => $tipeNota) {
                $get_m_w = DB::table('m_w')
                    ->where('m_w_m_kode_nota', $tipeNota)
                    ->join('m_jenis_nota', 'm_w_id', 'm_jenis_nota_m_w_id')
                    ->whereNotNull('m_jenis_nota_id')
                    ->first()->m_w_id;

                $queryNota = DB::table('m_jenis_nota')
                    ->join('m_menu_harga', 'm_menu_harga_m_jenis_nota_id', 'm_jenis_nota_id')
                    ->where('m_jenis_nota_m_w_id', $get_m_w)
                    ->whereIn('m_jenis_nota_m_t_t_id', $request->m_jenis_nota_trans_id)
                    ->where('m_menu_harga_m_produk_id', $request->m_menu_id);

                $notaHarga = $queryNota->pluck('m_menu_harga_nominal')->toArray();
                $data['nota_' . substr($tipeNota, 5) . '_harga'] = implode(', ', $notaHarga);
            }
        } else {
            if ($request->area_id == '0') {
                $mAreaId = null;
            } else {
                $mAreaId = $request->area_id;
            }
            $trans_tipe = $request->tipe_trans_id;
            $get_nota = DB::table('m_w')->when($mAreaId, function ($query) use ($mAreaId) {
                return $query->where('m_w_m_area_id', $mAreaId);
            })
                ->join('m_jenis_nota', 'm_jenis_nota_m_w_id', 'm_w_id')
                ->whereIn('m_jenis_nota_m_t_t_id', $trans_tipe)
                ->groupBy('m_w_m_kode_nota')
                ->pluck('m_w_m_kode_nota')->toArray();
            $data = $get_nota;
        }
        return response()->json($data);
    }
}
