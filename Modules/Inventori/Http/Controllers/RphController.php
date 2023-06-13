<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
class RphController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $rph = DB::table('rph')
            ->join('users', 'users_id', 'rph_created_by')
            ->where('rph_m_w_id', $waroeng_id)
            ->where('rph_created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('rph_created_at', 'desc')
            ->get();
        return view('inventori::form_input_rph', compact('rph', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->jenis = DB::table('m_jenis_produk')->whereNotIn('m_jenis_produk_id', [8, 9, 10, 11, 12, 13])->get();
        $data->produk = DB::table('m_produk')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])
            ->whereNotIn('m_produk_m_jenis_produk_id', [8, 9, 10, 11, 12, 13])
            ->where('m_produk_jual', 'ya')
            ->get();
        $data->num = 1;
        $data->n = 1;
        $data->s = 1;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->rph_code = $this->getNextId('rph', $waroeng_id);
        return view('inventori::form_input_rph_detail', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $cek_rph_valid = DB::table('rph')
            ->where('rph_m_w_id', $waroeng_id)
            ->where('rph_tgl', $request->rph_tgl)
            ->first();
        if (empty($cek_rph_valid)) {

            $rph = array(
                'rph_code' => $request->rph_code,
                'rph_tgl' => $request->rph_tgl,
                'rph_m_w_id' => $waroeng_id,
                'rph_m_w_nama' => strtolower($request->rph_m_w_nama),
                'rph_created_by' => Auth::user()->users_id,
                'rph_created_at' => Carbon::now(),
            );
            DB::table('rph')->insert($rph);
            foreach ($request->rph_detail_menu_m_produk_code as $key => $value) {
                if (!empty($request->rph_detail_menu_qty[$key])) {
                    $rph_detail_menu_id = $this->getNextId('rph_detail_menu', $waroeng_id);
                    $menu_nama = DB::table('m_produk')
                        ->where('m_produk_code', $request->rph_detail_menu_m_produk_code[$key])
                        ->select('m_produk_nama')
                        ->first();
                    $rph_menu = array(
                        'rph_detail_menu_id' => $rph_detail_menu_id,
                        'rph_detail_menu_rph_code' => $request->rph_code,
                        'rph_detail_menu_m_produk_code' => $request->rph_detail_menu_m_produk_code[$key],
                        'rph_detail_menu_m_produk_nama' => $menu_nama->m_produk_nama,
                        'rph_detail_menu_qty' => $request->rph_detail_menu_qty[$key],
                        'rph_detail_menu_created_by' => Auth::user()->users_id,
                        'rph_detail_menu_created_at' => Carbon::now(),
                    );
                    DB::table('rph_detail_menu')->insert($rph_menu);
                    $get_resep = DB::table('m_resep')
                        ->join('m_resep_detail', 'm_resep_code', 'm_resep_detail_m_resep_code')
                        ->where('m_resep_m_produk_code', $request->rph_detail_menu_m_produk_code[$key])
                        ->get();
                    foreach ($get_resep as $value) {
                        $get_std_resep = DB::table('m_std_bb_resep')
                            ->where('m_std_bb_resep_m_produk_code_asal', $value->m_resep_detail_bb_code)
                            ->where('m_std_bb_resep_gudang_status', 'produksi')
                            ->first();
                        if (!empty($get_std_resep)) {
                            $bb_qty = ($request->rph_detail_menu_qty[$key] * $value->m_resep_detail_bb_qty) / convertfloat($get_std_resep->m_std_bb_resep_qty);
                            $bb_code = $get_std_resep->m_std_bb_resep_m_produk_code_relasi;
                        } elseif (!is_null($value->m_resep_detail_standar_porsi)) {
                            $bb_qty = $request->rph_detail_menu_qty[$key] / $value->m_resep_detail_standar_porsi;
                            $bb_code = $value->m_resep_detail_bb_code;
                        } else {
                            // Skip penyimpanan dan perhitungan jika m_resep_detail_standar_porsi bernilai null
                            continue;
                        }

                        $detail_resep = array(
                            'rph_detail_bb_id' => $this->getNextId('rph_detail_bb', $waroeng_id),
                            'rph_detail_bb_rph_detail_menu_id' => $rph_detail_menu_id,
                            'rph_detail_bb_rph_code' => $request->rph_code,
                            'rph_detail_bb_m_produk_code' => $bb_code,
                            'rph_detail_bb_m_produk_nama' => $value->m_resep_detail_m_produk_nama,
                            'rph_detail_bb_qty' => $bb_qty,
                            'rph_detail_bb_created_at' => Carbon::now(),
                            'rph_detail_bb_created_by' => Auth::user()->users_id,
                        );
                        DB::table('rph_detail_bb')->insert($detail_resep);
                    }
                }
            }
            return response()->json(['messages' => 'Berhasil Menyimpan RPH', 'type' => 'success']);
        } else {
            return response()->json(['messages' => 'RPH dengan tanggal tsb sudah ada silahkan lakukan edit', 'type' => 'danger']);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->jenis = DB::table('m_jenis_produk')->whereNotIn('m_jenis_produk_id', [8, 9, 10, 11, 12, 13])->get();
        $data->produk = DB::table('m_produk')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])
            ->whereNotIn('m_produk_m_jenis_produk_id', [8, 9, 10, 11, 12, 13])
            ->where('m_produk_jual', 'ya')
            ->get();
        $data->num = 1;
        $data->n = 1;
        $data->s = 1;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->rph_code = $id;
        $data->rph_edit = DB::table('rph')
            ->join('rph_detail_menu', 'rph_detail_menu_rph_code', 'rph_code')
            ->where('rph_code', $id)->get();
        $data->rph_tgl = DB::table('rph')->where('rph_code', $id)->first()->rph_tgl;
        $data->aksi = 'edit';
        return view('inventori::form_input_rph_edit', compact('data'));
    }
    public function detail($id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->jenis = DB::table('m_jenis_produk')->whereNotIn('m_jenis_produk_id', [8, 9, 10, 11, 12, 13])->get();
        $data->produk = DB::table('m_produk')
            ->whereIn('m_produk_m_klasifikasi_produk_id', [4])
            ->whereNotIn('m_produk_m_jenis_produk_id', [8, 9, 10, 11, 12, 13])
            ->where('m_produk_jual', 'ya')
            ->get();
        $data->num = 1;
        $data->n = 1;
        $data->s = 1;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->rph_code = $id;
        $data->rph_edit = DB::table('rph')
            ->join('rph_detail_menu', 'rph_detail_menu_rph_code', 'rph_code')
            ->where('rph_code', $id)->get();
        $data->rph_tgl = DB::table('rph')->where('rph_code', $id)->first()->rph_tgl;
        $data->aksi = 'detail';
        return view('inventori::form_input_rph_edit', compact('data'));
    }
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        try {
        $cek_status_rph = DB::table('rph')->where('rph_code', $request->rph_code)->value('rph_order_status');
        if ($cek_status_rph == 'buka') {
            $waroeng_id = Auth::user()->waroeng_id;
            foreach ($request->rph_detail_menu_m_produk_code as $key => $value) {
                if (!empty($request->rph_detail_menu_qty[$key])) {
                    $menu_nama = DB::table('m_produk')
                        ->where('m_produk_code', $request->rph_detail_menu_m_produk_code[$key])
                        ->select('m_produk_nama')
                        ->first();
                    $id = (empty($request->rph_detail_menu_id[$key])) ? $this->getNextId('rph_detail_menu', $waroeng_id) : $request->rph_detail_menu_id[$key];
                    $rph_menu = array(
                        'rph_detail_menu_id' => $id,
                        'rph_detail_menu_rph_code' => $request->rph_code,
                        'rph_detail_menu_m_produk_code' => $request->rph_detail_menu_m_produk_code[$key],
                        'rph_detail_menu_m_produk_nama' => $menu_nama->m_produk_nama,
                        'rph_detail_menu_qty' => $request->rph_detail_menu_qty[$key],
                        'rph_detail_menu_created_by' => Auth::user()->users_id,
                        'rph_detail_menu_created_at' => Carbon::now(),
                    );
                    DB::table('rph_detail_menu')->updateOrInsert(
                        ['rph_detail_menu_rph_code' => $request->rph_code, 'rph_detail_menu_m_produk_code' => $request->rph_detail_menu_m_produk_code[$key]],
                        $rph_menu
                    );

                    $get_resep = DB::table('m_resep')
                        ->join('m_resep_detail', 'm_resep_code', 'm_resep_detail_m_resep_code')
                        ->where('m_resep_m_produk_code', $request->rph_detail_menu_m_produk_code[$key])
                        ->whereNotNull('m_resep_detail_standar_porsi')
                        ->get();
                    foreach ($get_resep as $value) {
                        $get_std_resep = DB::table('m_std_bb_resep')->where('m_std_bb_resep_m_produk_code_asal', $value->m_resep_detail_bb_code)->first();
                        if (!empty($get_std_resep)) {
                            $bb_qty = ($request->rph_detail_menu_qty[$key] * $value->m_resep_detail_bb_qty) / convertfloat($get_std_resep->m_std_bb_resep_qty);
                            $bb_code = $get_std_resep->m_std_bb_resep_m_produk_code_relasi;
                            $bb_nama = $get_std_resep->m_std_bb_resep_m_produk_nama_relasi;
                        } elseif (!is_null($value->m_resep_detail_standar_porsi)) {
                            $bb_qty = $request->rph_detail_menu_qty[$key] / $value->m_resep_detail_standar_porsi;
                            $bb_code = $value->m_resep_detail_bb_code;
                            $bb_nama = $value->m_resep_detail_m_produk_nama;
                        } else {
                            // Skip penyimpanan dan perhitungan jika m_resep_detail_standar_porsi bernilai null
                            continue;
                        }

                        $detail_resep = array(
                            'rph_detail_bb_id' => $this->getNextId('rph_detail_bb', $waroeng_id),
                            'rph_detail_bb_rph_detail_menu_id' => $id,
                            'rph_detail_bb_rph_code' => $request->rph_code,
                            'rph_detail_bb_m_produk_code' => $bb_code,
                            'rph_detail_bb_m_produk_nama' => $bb_nama,
                            'rph_detail_bb_qty' => $bb_qty,
                            'rph_detail_bb_created_at' => Carbon::now(),
                            'rph_detail_bb_created_by' => Auth::user()->users_id,
                        );
                        DB::table('rph_detail_bb')->updateOrInsert(['rph_detail_bb_rph_detail_menu_id' => $id,
                            'rph_detail_bb_m_produk_code' => $bb_code],
                            $detail_resep);
                    }
                }
            }
        } else {
            throw new Exception('RPH telah ditutup');
        }
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
    }
    public function belanja()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $rph = DB::table('rph')
            ->join('users', 'users_id', 'rph_created_by')
            ->where('rph_m_w_id', $waroeng_id)
            ->where('rph_created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('rph_created_at', 'desc')
            ->get();
        return view('inventori::list_belanja', compact('rph', 'data'));
    }
    public function belanja_detail($id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();

        $rph = DB::table('rph')->where('rph_code', $id)->first();

        $get_list = DB::table('rph')
            ->join('rph_detail_bb', 'rph_detail_bb_rph_code', 'rph_code')
            ->join('m_stok as ms1', function ($join1) use ($rph) {
                $join1->on('ms1.m_stok_m_produk_code', 'rph_detail_bb_m_produk_code')
                    ->join('m_gudang as mg1', function ($join2) use ($rph) {
                        $join2->on('ms1.m_stok_gudang_code', 'mg1.m_gudang_code')
                            ->where('mg1.m_gudang_nama', '=', 'gudang produksi waroeng')
                            ->where('mg1.m_gudang_m_w_id', '=', $rph->rph_m_w_id);
                    });
            })
            ->join('m_stok as ms2', function ($join1) use ($rph) {
                $join1->on('ms2.m_stok_m_produk_code', 'rph_detail_bb_m_produk_code')
                    ->join('m_gudang as mg2', function ($join2) use ($rph) {
                        $join2->on('ms2.m_stok_gudang_code', 'mg2.m_gudang_code')
                            ->where('mg2.m_gudang_nama', '=', 'gudang utama waroeng')
                            ->where('mg2.m_gudang_m_w_id', '=', $rph->rph_m_w_id);
                    });
            })
            ->select(
                'rph_detail_bb_m_produk_code',
                'rph_detail_bb_m_produk_nama',
                'ms1.m_stok_satuan as satuan1',
                'ms2.m_stok_satuan as satuan2',
                DB::raw('SUM(rph_detail_bb_qty) as qty_rph'),
                'ms1.m_stok_saldo as qty_produksi',
                'ms2.m_stok_saldo as qty_gudang',
            )
            ->groupBy('rph_detail_bb_m_produk_code', 'rph_detail_bb_m_produk_nama', 'qty_produksi', 'qty_gudang', 'satuan1', 'satuan2')
            ->where('rph_detail_bb_rph_code', $id)
            ->get();
        $no = 0;
        $data2 = array();
        foreach ($get_list as $value) {
            $get_std_resep = DB::table('m_std_bb_resep')->where('m_std_bb_resep_m_produk_code_asal', $value->rph_detail_bb_m_produk_code)->first();
            if (!empty($get_std_resep)) {
                $qty_kebutuhan_produksi = ($value->qty_rph - $value->qty_produksi) / $get_std_resep->m_std_bb_resep_porsi;
                if ($qty_kebutuhan_produksi < 0) {$qty_kebutuhan_produksi = 0;}
            } else {
                $qty_kebutuhan_produksi = $value->qty_rph - $value->qty_produksi;
                if ($qty_kebutuhan_produksi < 0) {$qty_kebutuhan_produksi = 0;}
            }
            $row = array();
            $no++;
            $row['no'] = $no;
            $row['nama'] = $value->rph_detail_bb_m_produk_nama;
            $row['qty_rph'] = number_format($value->qty_rph, 2);
            $row['qty_produksi'] = $value->qty_produksi;
            $row['sat_produksi'] = $value->satuan1;
            $row['kebutuhan'] = number_format($qty_kebutuhan_produksi, 2);
            $row['qty_gudang'] = $value->qty_gudang;
            $row['belanja'] = $retVal = ($qty_kebutuhan_produksi - $value->qty_gudang < 0) ? 0 : $qty_kebutuhan_produksi - $value->qty_gudang;
            $row['sat_belanja'] = $value->satuan2;
            $data2[] = $row;
        }
        return view('inventori::list_belanja_detail', compact('data', 'data2', 'rph'));
    }
    public function belanja_detail_lengkap($id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();

        $rph = DB::table('rph')->where('rph_code', $id)->first();

        $get_list = DB::table('rph')
            ->join('rph_detail_bb', 'rph_detail_bb_rph_code', 'rph_code')
            ->join('m_stok as ms1', function ($join1) use ($rph) {
                $join1->on('ms1.m_stok_m_produk_code', 'rph_detail_bb_m_produk_code')
                    ->join('m_gudang as mg1', function ($join2) use ($rph) {
                        $join2->on('ms1.m_stok_gudang_code', 'mg1.m_gudang_code')
                            ->where('mg1.m_gudang_nama', '=', 'gudang produksi waroeng')
                            ->where('mg1.m_gudang_m_w_id', '=', $rph->rph_m_w_id);
                    });
            })
            ->join('m_stok as ms2', function ($join1) use ($rph) {
                $join1->on('ms2.m_stok_m_produk_code', 'rph_detail_bb_m_produk_code')
                    ->join('m_gudang as mg2', function ($join2) use ($rph) {
                        $join2->on('ms2.m_stok_gudang_code', 'mg2.m_gudang_code')
                            ->where('mg2.m_gudang_nama', '=', 'gudang utama waroeng')
                            ->where('mg2.m_gudang_m_w_id', '=', $rph->rph_m_w_id);
                    });
            })
            ->select(
                'rph_detail_bb_m_produk_code',
                'rph_detail_bb_m_produk_nama',
                'ms1.m_stok_satuan as satuan1',
                'ms2.m_stok_satuan as satuan2',
                DB::raw('SUM(rph_detail_bb_qty) as qty_rph'),
                'ms1.m_stok_saldo as qty_produksi',
                'ms2.m_stok_saldo as qty_gudang',
            )
            ->groupBy('rph_detail_bb_m_produk_code', 'rph_detail_bb_m_produk_nama', 'qty_produksi', 'qty_gudang', 'satuan1', 'satuan2')
            ->where('rph_detail_bb_rph_code', $id)
            ->get();
        $no = 0;
        $data2 = array();
        foreach ($get_list as $value) {
            $get_std_resep = DB::table('m_std_bb_resep')->where('m_std_bb_resep_m_produk_code_asal', $value->rph_detail_bb_m_produk_code)->first();
            if (!empty($get_std_resep)) {
                $qty_kebutuhan_produksi = ($value->qty_rph - $value->qty_produksi) / $get_std_resep->m_std_bb_resep_porsi;
                if ($qty_kebutuhan_produksi < 0) {$qty_kebutuhan_produksi = 0;}
            } else {
                $qty_kebutuhan_produksi = $value->qty_rph - $value->qty_produksi;
                if ($qty_kebutuhan_produksi < 0) {$qty_kebutuhan_produksi = 0;}
            }
            $row = array();
            $no++;
            $row['no'] = $no;
            $row['nama'] = $value->rph_detail_bb_m_produk_nama;
            $row['qty_rph'] = $value->qty_rph;
            $row['qty_produksi'] = $value->qty_produksi;
            $row['sat_produksi'] = $value->satuan1;
            $row['kebutuhan'] = number_format($qty_kebutuhan_produksi, 2);
            $row['qty_gudang'] = $value->qty_gudang;
            $row['belanja'] = $retVal = ($qty_kebutuhan_produksi - $value->qty_gudang < 0) ? 0 : $qty_kebutuhan_produksi - $value->qty_gudang;
            $row['sat_belanja'] = $value->satuan2;
            $data2[] = $row;
        }
        return $data2;
    }
    public function order_produksi(Request $request)
    {
        // DB::table('rph')->where('rph_code', $request->rph_code)
        //     ->update(['rph_order_status' => 'tutup',
        //         'rph_updated_by' => Auth::user()->users_id]);
      return  $data = $this->belanja_detail_lengkap($request->rph_code);
        $lokasi = ['produksi','gudang'];
        foreach ($lokasi as $key) {
            foreach ($data as $val => $value) {
                
            }
        }
        
    }
}
