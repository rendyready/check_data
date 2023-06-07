<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MStokController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $gudang = DB::table('m_gudang')
            ->join('m_w', 'm_w_id', 'm_gudang_m_w_id')
            ->select('m_gudang_code', 'm_gudang_nama', 'm_w_nama')->get();
        $waroeng_id = Auth::user()->waroeng_id;
        $tgl_now = Carbon::now()->format('Y-m-d');
        return view('inventori::form_stok_awal', compact('gudang', 'tgl_now'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    function list($id) {
        $stok = DB::table('m_stok')
            ->where('m_stok_gudang_code', $id)
            ->orderByRaw('m_stok_updated_at is NULL')
            ->orderByDesc('m_stok_updated_at')
            ->get();
        $no = 0;
        $data = array();
        foreach ($stok as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = ucwords($value->m_stok_produk_nama);
            $row[] = $value->m_stok_awal;
            $row[] = $value->m_stok_hpp;
            $row[] = $value->m_stok_satuan;
            $row[] = $retVal = (empty($value->m_stok_updated_at)) ? tgl_waktuid($value->m_stok_created_at) : tgl_waktuid($value->m_stok_updated_at);
            $data[] = $row;
        }
        $output = array('data' => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $messages = ['required' => 'Gudang Wajib dipilih Dahulu !'];
        $validated = $request->validate([
            'm_stok_gudang_code' => 'required',
        ], $messages);
        foreach ($request->m_stok_m_produk_code as $key => $value) {
            $cek = DB::table('m_stok')->where('m_stok_gudang_code', $request->m_stok_gudang_code)
                ->where('m_stok_m_produk_code', $request->m_stok_m_produk_code[$key])->first();
            $hpp = $cek->m_stok_hpp;
            $saldo = $cek->m_stok_saldo;
            $hpp_new = (($hpp * $saldo) + (convertfloat($request->m_stok_awal[$key]) * convertfloat($request->m_stok_hpp[$key]))) / ($saldo + convertfloat($request->m_stok_awal[$key]));

            $data = array(
                'm_stok_awal' => convertfloat($request->m_stok_awal[$key]),
                'm_stok_hpp' => $hpp_new,
                'm_stok_status_sync' => 'send',
                'm_stok_saldo' => $saldo + convertfloat($request->m_stok_awal[$key]),
                'm_stok_updated_at' => Carbon::now(),
            );

            DB::table('m_stok')->where('m_stok_gudang_code', $request->m_stok_gudang_code)
                ->where('m_stok_m_produk_code', $request->m_stok_m_produk_code[$key])->update($data);

        }
        return response()->json(['message' => 'Sukses Menambah Stok Awal', 'type' => 'success']);

    }
    public function master_stok($id)
    {
        $data = DB::table('m_stok')->where('m_stok_gudang_code', $id)
            ->get();
        $list = array();
        foreach ($data as $key => $v) {
            $list[$v->m_stok_m_produk_code] = $v->m_stok_produk_nama;
        }
        return response()->json($list);
    }
    public function get_harga($id_g, $id_p)
    {
        $data = DB::table('m_stok')
            ->where('m_stok_gudang_code', $id_g)
            ->where('m_stok_m_produk_code', $id_p)
            ->first();
        return response()->json($data);
    }
    public function so_index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')->where('m_gudang_m_w_id', $waroeng_id)->get();
        $data->klasifikasi = DB::table('m_klasifikasi_produk')->whereNotIn('m_klasifikasi_produk_id', [4])->get();
        return view('inventori::form_input_so', compact('data'));
    }

    public function so_list(Request $request)
    {
        $so = DB::table('rekap_so')
            ->join('users', 'users_id', 'rekap_so_created_by')
            ->join('m_klasifikasi_produk', 'm_klasifikasi_produk_id', 'rekap_so_m_klasifikasi_produk_id')
            ->where('rekap_so_m_gudang_code', $request->g_id)
            ->where('rekap_so_m_klasifikasi_produk_id', $request->kat_id)
            ->where('rekap_so_created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('rekap_so_created_at', 'desc')
            ->get();

        $no = 0;
        $data = array();
        foreach ($so as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = tgl_indo($value->rekap_so_tgl);
            $row[] = ucwords($value->name);
            $row[] = $value->m_klasifikasi_produk_nama;
            $row[] = tgl_waktuid($value->rekap_so_created_at);
            $row[] = '<button class="btn btn-warning"><i class="fa fa-eye">Detail</i></button>';
            $data[] = $row;
        }
        $output = array('data' => $data);
        return response()->json($output);
    }

    public function so_create($g_id, $kat_id)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass ();
        $data->stok = DB::table('m_stok')
            ->where('m_stok_gudang_code', $g_id)
            ->where('m_stok_m_klasifikasi_produk_id', $kat_id)
            ->orderBy('m_stok_id', 'asc')
            ->get();
        $data->waroeng = DB::table('m_w')->where('m_w_id', $waroeng_id)->first();
        $data->so_code = $this->getNextId('rekap_so', $waroeng_id);
        $data->tgl_now = tgl_indo(Carbon::now());
        $data->gudang_nama = DB::table('m_gudang')->where('m_gudang_code', $g_id)->first()->m_gudang_nama;
        $data->gudang_code = $g_id;
        $data->kat_id = $kat_id;
        return view('inventori::form_input_so_detail', compact('data'));
    }
    public function so_simpan(Request $request)
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $so_code = $this->getNextId('rekap_so', $waroeng_id);
        $so_nota = array(
            'rekap_so_code' => $so_code,
            'rekap_so_tgl' => tgl_indo_to_en($request->rekap_so_tgl),
            'rekap_so_m_klasifikasi_produk_id' => $request->rekap_so_m_klasifikasi_produk_id,
            'rekap_so_m_gudang_code' => $request->rekap_so_m_gudang_code,
            'rekap_so_m_w_code' => $request->rekap_so_m_w_code,
            'rekap_so_m_w_nama' => strtolower($request->rekap_so_m_w_nama),
            'rekap_so_created_by' => Auth::user()->users_id,
            'rekap_so_created_at' => Carbon::now(),
        );
        DB::table('rekap_so')->insert($so_nota);
    
        foreach ($request->rekap_so_detail as $detailData) {
            $qty_riil = $detailData['rekap_so_detail_qty_riil'] ?? null;
            if (!is_null($qty_riil)) {
               $produk = DB::table('m_stok')
                    ->where('m_stok_m_produk_code', $detailData['rekap_so_detail_m_produk_code'])
                    ->where('m_stok_gudang_code', $request->rekap_so_m_gudang_code)
                    ->first();
    
                if (!is_null($produk)) {
                    $detail = array(
                        'rekap_so_detail_id' => $this->getNextId('rekap_so_detail', $waroeng_id),
                        'rekap_so_detail_m_gudang_code' => $request->rekap_so_m_gudang_code,
                        'rekap_so_detail_m_produk_code' => $detailData['rekap_so_detail_m_produk_code'],
                        'rekap_so_detail_m_produk_nama' => $produk->m_stok_produk_nama,
                        'rekap_so_detail_satuan' => $detailData['rekap_so_detail_satuan'],
                        'rekap_so_detail_qty' => $detailData['rekap_so_detail_qty'],
                        'rekap_so_detail_qty_riil' => $qty_riil,
                        'rekap_so_detail_created_by' => Auth::user()->users_id,
                        'rekap_so_detail_updated_at' => Carbon::now(),
                    );
    
                    DB::table('rekap_so_detail')->insert($detail);
                        $saldo_terakhir = $produk->m_stok_saldo;
                        $detail_so = array(
                            'm_stok_detail_id' => $this->getMasterId('m_stok_detail'),
                            'm_stok_detail_code' => $this->getNextId('m_stok_detail', $waroeng_id),
                            'm_stok_detail_m_produk_code' => $detailData['rekap_so_detail_m_produk_code'],
                            'm_stok_detail_tgl' => Carbon::now(),
                            'm_stok_detail_m_produk_nama' => $produk->m_stok_produk_nama,
                            'm_stok_detail_satuan_id' => $produk->m_stok_satuan_id,
                            'm_stok_detail_satuan' => $produk->m_stok_satuan,
                            'm_stok_detail_so' => $qty_riil,
                            'm_stok_detail_saldo' => $saldo_terakhir,
                            'm_stok_detail_hpp' => $produk->m_stok_hpp,
                            'm_stok_detail_catatan' => 'so ' . $so_code,
                            'm_stok_detail_gudang_code' => $request->rekap_so_m_gudang_code,
                            'm_stok_detail_status_sync' => 'send',
                            'm_stok_detail_created_by' => Auth::user()->users_id,
                            'm_stok_detail_created_at' => Carbon::now(),
                        );
                        DB::table('m_stok_detail')->insert($detail_so);
                        DB::table('m_stok')
                            ->where('m_stok_gudang_code', $request->rekap_so_m_gudang_code)
                            ->where('m_stok_m_produk_code', $detailData['rekap_so_detail_m_produk_code'])
                            ->update([
                                'm_stok_saldo' => $qty_riil,
                                'm_stok_status_sync' => 'send',
                                'm_stok_updated_at' => Carbon::now(),
                                'm_stok_updated_by' => Auth::user()->users_id,
                            ]);
                    
                }
            }
        }
    }
    
}
