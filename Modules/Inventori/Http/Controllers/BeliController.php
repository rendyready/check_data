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
        ->where('m_supplier_m_w_id',$user_mwid)
        ->get();
        $satuan = DB::table('m_satuan')->get();
        foreach ($nama_barang as $key => $v) {
            $data->barang[$v->m_produk_code] = $v->m_produk_nama;
        }
        foreach ($supplierku as $key => $v) {
            $data->supplier[$v->m_supplier_id] = $v->m_supplier_nama;
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
        $terbayar = (empty($request->rekap_beli_terbayar)) ? 0 : $request->rekap_beli_terbayar;
        $ongkir = (empty($request->rekap_beli_ongkir)) ? 0 : $request->rekap_beli_ongkir;
        $rekap_beli = array(
            'r_t_jb_id' => $request->rekap_beli_code,
            'r_t_jb_code_nota' => $request->rekap_beli_code_nota,
            'r_t_jb_tgl' => $request->rekap_beli_tgl,
            'r_t_jb_jth_tmp' => $request->rekap_beli_jth_tmp,
            'r_t_jb_supplier_code' => $request->rekap_beli_supplier_code,
            'r_t_jb_supplier_nama' => $request->rekap_beli_supplier_nama,
            'r_t_jb_supplier_telp' => $request->rekap_beli_supplier_telp,
            'r_t_jb_supplier_alamat' => $request->rekap_beli_supplier_alamat,
            'r_t_jb_m_w_id' => Auth::user()->waroeng_id,
            'r_t_jb_gudang_code' => $request->rekap_beli_gudang_code,
            'r_t_jb_waroeng' => $request->rekap_beli_waroeng,
            'r_t_jb_disc' => $request->rekap_beli_disc,
            'r_t_jb_disc_rp' => convertfloat($request->rekap_beli_disc_rp),
            'r_t_jb_ppn' => $request->rekap_beli_ppn,
            'r_t_jb_ppn_rp' => convertfloat($request->rekap_beli_ppn_rp),
            'r_t_jb_ongkir' => convertfloat($ongkir),
            'r_t_jb_terbayar' => convertfloat($terbayar),
            'r_t_jb_sub_tot' => convertfloat($request->rekap_beli_tot_no_ppn),
            'rekap_beli_tot_nom' => convertfloat($request->rekap_beli_tot_nom),
            'rekap_beli_ket' => 'pembelian mandiri',
            'rekap_beli_created_at' => Carbon::now(),
            'rekap_beli_created_by' => Auth::user()->users_id,
        );

        $insert = DB::table('rekap_beli')->insert($rekap_beli);
        foreach ($request->rekap_beli_detail_qty as $key => $value) {
            $produk = DB::table('m_stok')
                ->where('m_stok_m_produk_code', $request->rekap_beli_detail_m_produk_id[$key])
                ->where('m_stok_gudang_code', $request->rekap_beli_gudang_code)
                ->first();
            $data = array(
                'rekap_beli_detail_id' => $this->getNextId('rekap_beli_detail', Auth::user()->waroeng_id),
                'rekap_beli_detail_rekap_beli_code' => $request->rekap_beli_code,
                'rekap_beli_detail_m_produk_code' => $request->rekap_beli_detail_m_produk_id[$key],
                'rekap_beli_detail_m_produk_nama' => $produk->m_stok_produk_nama,
                'rekap_beli_detail_satuan_id' => $produk->m_stok_satuan_id,
                'rekap_beli_detail_satuan_terima' => $produk->m_stok_satuan,
                'rekap_beli_detail_catatan' => $request->rekap_beli_detail_catatan[$key],
                'rekap_beli_detail_qty' => convertfloat($request->rekap_beli_detail_qty[$key]),
                'rekap_beli_detail_harga' => convertfloat($request->rekap_beli_detail_harga[$key]),
                'rekap_beli_detail_disc' => $request->rekap_beli_detail_disc[$key],
                'rekap_beli_detail_discrp' => convertfloat($request->rekap_beli_detail_discrp[$key]),
                'rekap_beli_detail_subtot' => convertfloat($request->rekap_beli_detail_subtot[$key]),
                'rekap_beli_detail_m_w_id' => Auth::user()->waroeng_id,
                'rekap_beli_detail_created_by' => Auth::user()->users_id,
                'rekap_beli_detail_created_at' => Carbon::now(),
            );
            DB::table('rekap_beli_detail')->insert($data);
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
        $rekap_beli = DB::table('rekap_beli')
            ->join('users', 'rekap_beli_created_by', 'users_id')
            ->where('rekap_beli_tgl', $tgl_now)
            ->where('rekap_beli_gudang_code', $id)
            ->orderBy('rekap_beli_created_at', 'desc')
            ->get();

        $data = array();
        foreach ($rekap_beli as $value) {
            $row = array();
            $row[] = $value->rekap_beli_code;
            $row[] = $value->rekap_beli_supplier_nama;
            $row[] = rupiah($value->rekap_beli_tot_nom);
            $row[] = $value->name;
            $row[] = tgl_waktuid($value->rekap_beli_created_at);
            $row[] = '<a id="detail" class="btn btn-sm detail btn-warning" value="' . $value->rekap_beli_code . '" title="Edit"><i class="fa fa-eye"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }
    public function hist_pemb_detail($id)
    {
        $rekap_beli_detail = DB::table('rekap_beli_detail')
            ->where('rekap_beli_detail_rekap_beli_code', $id)
            ->orderBy('rekap_beli_detail_created_at', 'desc')
            ->get();

        $data = array();
        $no = 1;
        foreach ($rekap_beli_detail as $value) {
            $row = array();
            $row[] = $no;
            $row[] = $value->rekap_beli_detail_m_produk_nama;
            $row[] = $value->rekap_beli_detail_qty;
            $row[] = rupiah($value->rekap_beli_detail_harga);
            $row[] = rupiah($value->rekap_beli_detail_discrp);
            $row[] = rupiah($value->rekap_beli_detail_subtot);
            $row[] = $value->rekap_beli_detail_catatan;
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
