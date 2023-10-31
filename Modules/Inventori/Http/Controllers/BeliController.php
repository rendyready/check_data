<?php

namespace Modules\Inventori\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeliController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = new \stdClass();
        $user = Auth::user()->users_id;
        $waroeng_id = Auth::user()->waroeng_id;
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama')->where('m_w_id', $waroeng_id)->first();
        $data->tgl_now = Carbon::now()->format('Y-m-d');
        $data->gudang = DB::table('m_gudang')
            ->where('m_gudang_m_w_id', Auth::user()->waroeng_id)
            ->whereNotIn('m_gudang_nama', ['gudang produksi waroeng'])
            ->get();
        $data->m_w_id = $waroeng_id;
        $data->m_jenis_belanja = DB::table('m_jenis_belanja')->get();
        return view('inventori::form_beli', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list()
    {
        $data = new \stdClass();
        $user_mwid = Auth::user()->waroeng_id;
        $nama_barang = DB::table('m_produk')
            ->select('m_produk_code', 'm_produk_nama')->whereNotIn('m_produk_m_klasifikasi_produk_id', [4])->get();
        $supplierku = DB::table('m_supplier')
            ->where('m_supplier_m_w_id', $user_mwid)
            ->get();
        $satuan = DB::table('m_satuan')->get();
        foreach ($nama_barang as $key => $v) {
            $data->barang[$v->m_produk_code] = $v->m_produk_nama;
        }
        foreach ($supplierku as $key => $v) {
            $data->supplier[$v->m_supplier_code] = $v->m_supplier_nama;
        }
        foreach ($satuan as $key => $v) {
            $data->satuan[$v->m_satuan_id] = $v->m_satuan_kode;
        }
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function simpan(Request $request)
    {
        $id_waroeng = Auth::user()->waroeng_id;
        $area = $this->getAreaMw($id_waroeng);
        $terbayar = (empty($request->r_t_jb_terbayar)) ? 0 : $request->r_t_jb_terbayar;
        $ongkir = (empty($request->r_t_jb_ongkir)) ? 0 : $request->r_t_jb_ongkir;
        $r_t_jb = array(
            'r_t_jb_id' => $request->r_t_jb_code,
            'r_t_jb_code_nota' => $request->r_t_jb_code_nota,
            'r_t_jb_tgl' => $request->r_t_jb_tgl,
            'r_t_jb_jth_tmp' => $request->r_t_jb_jth_tmp,
            'r_t_jb_type' => 'beli',
            'r_t_jb_m_gudang_code_tujuan' => $request->r_t_jb_m_gudang_code,
            'r_t_jb_m_supplier_code' => $request->r_t_jb_m_supplier_code,
            'r_t_jb_m_supplier_nama' => $request->r_t_jb_m_supplier_nama,
            'r_t_jb_m_supplier_telp' => $request->r_t_jb_m_supplier_telp,
            'r_t_jb_m_supplier_alamat' => $request->r_t_jb_m_supplier_alamat,
            'r_t_jb_m_w_id_asal' => $id_waroeng,
            'r_t_jb_m_w_nama_asal' => $request->r_t_jb_waroeng,
            'r_t_jb_m_w_id_tujuan' => $id_waroeng,
            'r_t_jb_m_w_nama_tujuan' => $request->r_t_jb_waroeng,
            'r_t_jb_m_area_code_asal' => $area->m_area_code,
            'r_t_jb_m_area_nama_asal' => $area->m_area_nama,
            'r_t_jb_m_area_code_tujuan' => $area->m_area_code,
            'r_t_jb_m_area_nama_tujuan' => $area->m_area_nama,
            'r_t_jb_sub_total_beli' => convertfloat($request->r_t_jb_sub_total_beli),
            'r_t_jb_disc' => $request->r_t_jb_disc,
            'r_t_jb_nominal_disc' => convertfloat($request->r_t_jb_nominal_disc),
            'r_t_jb_ppn' => $request->r_t_jb_ppn,
            'r_t_jb_nominal_ppn' => convertfloat($request->r_t_jb_nominal_ppn),
            'r_t_jb_nominal_ongkir' => convertfloat($ongkir),
            'r_t_jb_nominal_total_beli' => convertfloat($request->r_t_jb_nominal_total_beli),
            'r_t_jb_nominal_bayar' => 0,
            'r_t_jb_ket' => strtolower($request->m_jenis_belanja),
            'r_t_jb_created_at' => Carbon::now(),
            'r_t_jb_created_by' => Auth::user()->users_id,
        );

        $insert = DB::table('rekap_trans_jualbeli')->insert($r_t_jb);
        if ($request->r_t_jb_nominal_bayar) {
            $kas = array(
                'r_t_jb_id' => $this->getNextId('rekap_trans_jualbeli', Auth::user()->waroeng_id),
                'r_t_jb_tgl' => $request->r_t_jb_tgl,
                'r_t_jb_type' => 'bayar-hutang',
                'r_t_jb_m_gudang_code_tujuan' => $request->r_t_jb_m_gudang_code,
                'r_t_jb_m_supplier_code' => $request->r_t_jb_m_supplier_code,
                'r_t_jb_m_supplier_nama' => $request->r_t_jb_m_supplier_nama,
                'r_t_jb_m_supplier_telp' => $request->r_t_jb_m_supplier_telp,
                'r_t_jb_m_supplier_alamat' => $request->r_t_jb_m_supplier_alamat,
                'r_t_jb_m_w_id_asal' => $id_waroeng,
                'r_t_jb_m_w_nama_asal' => $request->r_t_jb_waroeng,
                'r_t_jb_m_w_id_tujuan' => $id_waroeng,
                'r_t_jb_m_w_nama_tujuan' => $request->r_t_jb_waroeng,
                'r_t_jb_nominal_bayar' => convertfloat($request->r_t_jb_nominal_bayar),
                'r_t_jb_ket' => 'pembayaran hutang-kas',
                'r_t_jb_created_at' => Carbon::now(),
                'r_t_jb_created_by' => Auth::user()->users_id,
            );
            DB::table('rekap_trans_jualbeli')->insert($kas);
        }
        foreach ($request->r_t_jb_detail_qty as $key => $value) {
            $produk = DB::table('m_stok')
                ->where('m_stok_m_produk_code', $request->r_t_jb_detail_m_produk_id[$key])
                ->where('m_stok_gudang_code', $request->r_t_jb_m_gudang_code)
                ->first();
            $nom_disc = ($request->r_t_jb_detail_nominal_disc[$key] ?? null) !== null ? convertfloat($request->r_t_jb_detail_nominal_disc[$key]) : 0;

            $data = array(
                'r_t_jb_detail_id' => $this->getNextId('rekap_trans_jualbeli_detail', Auth::user()->waroeng_id),
                'r_t_jb_detail_r_t_jb_id' => $request->r_t_jb_code,
                'r_t_jb_detail_m_produk_code' => $request->r_t_jb_detail_m_produk_id[$key],
                'r_t_jb_detail_m_produk_nama' => $produk->m_stok_produk_nama,
                'r_t_jb_detail_satuan_id' => $produk->m_stok_satuan_id,
                'r_t_jb_detail_satuan_terima' => $produk->m_stok_satuan,
                'r_t_jb_detail_catatan' => $request->r_t_jb_detail_catatan[$key],
                'r_t_jb_detail_qty' => convertfloat($request->r_t_jb_detail_qty[$key]),
                'r_t_jb_detail_harga' => convertfloat($request->r_t_jb_detail_harga[$key]),
                'r_t_jb_detail_disc' => $request->r_t_jb_detail_disc[$key],
                'r_t_jb_detail_nominal_disc' => $nom_disc,
                'r_t_jb_detail_subtot_beli' => convertfloat($request->r_t_jb_detail_subtot[$key]),
                'r_t_jb_detail_m_w_id' => Auth::user()->waroeng_id,
                'r_t_jb_detail_created_by' => Auth::user()->users_id,
                'r_t_jb_detail_created_at' => Carbon::now(),
            );
            DB::table('rekap_trans_jualbeli_detail')->insert($data);
        }
        return response()->json(['success' => 'Pembelian Berhasil']);
    }
    public function select(Request $request)
    {

        $data = DB::table('m_produk')->whereNotIn('m_produk_code', $request->id)
            ->select('m_produk_code', 'm_produk_nama')->get();
        foreach ($data as $key => $value) {
            $list[$value->m_produk_code] = $value->m_produk_nama;
        }
        return response()->json($list);
    }
    public function hist_pemb($id)
    {
        $tgl_now = Carbon::now();
        $r_t_jb = DB::table('rekap_trans_jualbeli')
            ->join('users', 'r_t_jb_created_by', 'users_id')
            ->where('r_t_jb_tgl', $tgl_now)
            ->where('r_t_jb_type','beli')
            ->where('r_t_jb_m_gudang_code_tujuan', $id)
            ->orderBy('r_t_jb_created_at', 'desc')
            ->get();

        $data = array();
        foreach ($r_t_jb as $value) {
            $row = array();
            $row[] = $value->r_t_jb_id;
            $row[] = $value->r_t_jb_m_supplier_nama;
            $row[] = convertindo($value->r_t_jb_nominal_total_beli);
            $row[] = $value->name;
            $row[] = tgl_waktuid($value->r_t_jb_created_at);
            $row[] = '<a id="detail" class="btn btn-sm detail btn-warning" value="' . $value->r_t_jb_id . '" title="Edit"><i class="fa fa-eye"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function hist_pemb_detail($id)
    {
        $r_t_jb_detail = DB::table('rekap_trans_jualbeli_detail')
            ->where('r_t_jb_detail_r_t_jb_id', $id)
            ->orderBy('r_t_jb_detail_created_at', 'desc')
            ->get();

        $data = array();
        $no = 1;
        foreach ($r_t_jb_detail as $value) {
            $row = array();
            $row[] = $no;
            $row[] = $value->r_t_jb_detail_m_produk_nama;
            $row[] = $value->r_t_jb_detail_qty;
            $row[] = rupiah($value->r_t_jb_detail_harga);
            $row[] = rupiah($value->r_t_jb_detail_nominal_disc);
            $row[] = rupiah($value->r_t_jb_detail_subtot_beli);
            $row[] = $value->r_t_jb_detail_catatan;
            $data[] = $row;
            $no++;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function get_code()
    {
        $code = $this->getNextId('rekap_trans_jualbeli', Auth::user()->waroeng_id);
        return response()->json($code);
    }
}
