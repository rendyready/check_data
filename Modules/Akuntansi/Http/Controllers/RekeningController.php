<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {       
        $data = new \stdClass();
        $data->waroeng = DB::table('m_w')
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->rekening = DB::table('m_rekening')
            ->join('m_w', 'm_w_code', 'm_rekening_m_waroeng_id')
            ->select('m_rekening_kategori', 'm_rekening_no_akun', 'm_rekening_nama', 'm_rekening_saldo')
            ->orderBy('m_rekening_id', 'DESC')
            ->get();
        return view('akuntansi::rekening', compact('data'));
    }

    public function tampil(Request $request)
    {
        $get = DB::table('m_rekening')
                ->join('m_w', 'm_w_code', 'm_rekening_m_waroeng_id')
                ->where('m_rekening_kategori', $request->m_rekening_kategori)
                ->where('m_rekening_m_waroeng_id', $request->m_rekening_m_waroeng_id)
                ->orderBy('m_rekening_no_akun', 'ASC')
                ->get();
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = $value->m_rekening_kategori;
            $row[] = $value->m_rekening_no_akun;
            $row[] = $value->m_rekening_nama;
            $row[] = rupiah($value->m_rekening_saldo);
            $row[] = '<a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="'.$value->m_rekening_no_akun.'" title="Edit"><i class="fa fa-pencil"></i></a> <a id="buttonHapus" class="btn btn-sm buttonHapus btn-warning" value="'.$value->m_rekening_no_akun.'" title="Hapus"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function validasinama(Request $request)
    {
        $validasi = DB::table('m_rekening')
            ->where('m_rekening_nama', $request->m_rekening_nama)
            ->where('m_rekening_m_waroeng_id', $request->m_rekening_m_waroeng_id)
            ->count();
        return response()->json($validasi);
    }

    public function validasino(Request $request)
    {
        $validasi = DB::table('m_rekening')
            ->where('m_rekening_no_akun', $request->m_rekening_no_akun)
            ->where('m_rekening_m_waroeng_id', $request->m_rekening_m_waroeng_id)
            ->count();
        return response()->json($validasi);
    }

    public function simpan(Request $request)
    {
        foreach ($request->m_rekening_no_akun as $key => $value) {
            $str1 = str_replace('.', '', $request->m_rekening_saldo[$key]);
            $data = array(
                'm_rekening_id' => $this->getMasterId('m_rekening'),
                'm_rekening_m_waroeng_id' => $request->m_rekening_m_waroeng_id,
                'm_rekening_kategori' => $request->m_rekening_kategori,
                'm_rekening_no_akun' => $request->m_rekening_no_akun[$key],
                'm_rekening_nama' => strtolower($request->m_rekening_nama[$key]),
                'm_rekening_saldo' => str_replace(',', '.', $str1),
                'm_rekening_created_by' => Auth::user()->users_id,
                'm_rekening_created_at' => Carbon::now()
            );
            DB::table('m_rekening')->insert($data);
        }
        return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);

    }

    public function copyrecord(Request $request)
    {
        $get_data = DB::table('m_rekening')
            ->where('m_rekening_m_waroeng_id', $request->waroeng_asal)
            ->get();
        foreach ($get_data as $key) {
            $get_data2 = DB::table('m_rekening')
                ->where('m_rekening_m_waroeng_id', $request->waroeng_tujuan)
                ->where('m_rekening_kategori', $key->m_rekening_kategori)
                ->where('m_rekening_no_akun', $key->m_rekening_no_akun)
                ->where('m_rekening_nama', $key->m_rekening_nama)
                ->first();
            if (empty($get_data2)) {
                $saldo = ($request->m_rekening_copy_saldo == 'tidak') ? 0 : $key->m_rekening_saldo ;
                $data = array(
                    'm_rekening_id' => $this->getMasterId('m_rekening'),
                    'm_rekening_m_waroeng_id' => $request->waroeng_tujuan,
                    'm_rekening_kategori' => $key->m_rekening_kategori,
                    'm_rekening_no_akun' => $key->m_rekening_no_akun,
                    'm_rekening_nama' => $key->m_rekening_nama,
                    'm_rekening_saldo' => $saldo,
                    'm_rekening_created_by' => Auth::user()->users_id,
                    'm_rekening_created_at' => Carbon::now()
                );
                DB::table('m_rekening')->insert($data);
            }
        }
        return response()->json(['messages' => 'Berhasil copy ke waroeng lain', 'type' => 'success']);
    }

    public function edit($id)
    {
        $data = DB::table('m_rekening')->where('m_rekening_no_akun',$id)->first();
        return response()->json($data);
    }

    public function simpan_edit(Request $request)
    {
        $rekening_old = $request->m_rekening_id;
        $validasi1 = DB::table('rekap_jurnal_kas')
                    ->select('rekap_jurnal_kas_m_rekening_no_akun')
                    ->where('rekap_jurnal_kas_m_rekening_no_akun', $request->m_rekening_no_akun)
                    ->count();

        $validasi2 = DB::table('rekap_jurnal_bank')
                    ->select('rekap_jurnal_bank_m_rekening_no_akun')
                    ->where('rekap_jurnal_bank_m_rekening_no_akun', $request->m_rekening_no_akun)
                    ->count();

        $validasi3 = DB::table('rekap_jurnal_umum')
                    ->select('rekap_jurnal_umum_m_rekening_no_akun')
                    ->where('rekap_jurnal_umum_m_rekening_no_akun', $request->m_rekening_no_akun)
                    ->count();

        $validasi4 = DB::table('rekap_link_akuntansi')
                    ->select('rekap_link_akuntansi_m_rekening_id')
                    ->where('rekap_link_akuntansi_m_rekening_id', $request->m_rekening_no_akun)
                    ->count();

        $validasi = $validasi1 + $validasi2 + $validasi3 + $validasi4;
        if($validasi == 0){
        $str1 = str_replace('.', '', $request->m_rekening_saldo);
        $data = array(
            'm_rekening_no_akun'	=>	$request->m_rekening_no_akun,
            'm_rekening_nama'	    =>	$request->m_rekening_nama,
            'm_rekening_saldo'	    =>	str_replace(',', '.', $str1),
            'm_rekening_updated_by' => Auth::user()->users_id,
            'm_rekening_updated_at' => Carbon::now(),
        );
       return $update = DB::table('m_rekening')->where('m_rekening_no_akun', $rekening_old)
        ->update($data);

        return response()->json($update); 
    } 
    return response()->json($validasi);
    }

    public function delete(Request $request, $id)
    {
        $validasi1 = DB::table('rekap_jurnal_kas')
                    ->select('rekap_jurnal_kas_m_rekening_no_akun')
                    ->where('rekap_jurnal_kas_m_rekening_no_akun', $request->m_rekening_no_akun)
                    ->count();

        $validasi2 = DB::table('rekap_jurnal_bank')
                    ->select('rekap_jurnal_bank_m_rekening_no_akun')
                    ->where('rekap_jurnal_bank_m_rekening_no_akun', $request->m_rekening_no_akun)
                    ->count();

        $validasi3 = DB::table('rekap_jurnal_umum')
                    ->select('rekap_jurnal_umum_m_rekening_no_akun')
                    ->where('rekap_jurnal_umum_m_rekening_no_akun', $request->m_rekening_no_akun)
                    ->count();

        $validasi4 = DB::table('rekap_link_akuntansi')
                    ->select('rekap_link_akuntansi_m_rekening_id')
                    ->where('rekap_link_akuntansi_m_rekening_id', $request->m_rekening_no_akun)
                    ->count();
        $validasi = $validasi1 + $validasi2 + $validasi3 + $validasi4;
        if($validasi === 0){
        $delete = DB::table('m_rekening')
            ->where('m_rekening_no_akun', $id)
            ->delete();
            return response()->json($delete);
        }
        return response()->json($validasi);
    }
}
