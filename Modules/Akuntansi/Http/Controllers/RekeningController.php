<?php

namespace Modules\Akuntansi\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->select('m_rekening_kategori', 'm_rekening_code', 'm_rekening_nama', 'm_rekening_saldo')
            ->orderBy('m_rekening_id', 'DESC')
            ->get();
        return view('akuntansi::rekening', compact('data'));
    }

    public function tampil(Request $request)
    {
        $get = DB::table('m_rekening')
            ->where('m_rekening_kategori', $request->m_rekening_kategori)
            ->where('m_rekening_m_w_id', $request->m_rekening_m_waroeng_id)
            ->orderBy('m_rekening_code', 'ASC')
            ->get();
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $row[] = $value->m_rekening_kategori;
            $row[] = $value->m_rekening_code;
            $row[] = $value->m_rekening_nama;
            $row[] = rupiah($value->m_rekening_saldo, 0);
            $row[] =
            '<div class="text-center"><a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="' . $value->m_rekening_code . '" title="Edit"><i class="fa fa-pencil"></i></a>
            <a id="buttonSaldo" class="btn btn-sm buttonSaldo btn-primary" value="' . $value->m_rekening_code . '" title="Edit Saldo"><i class="fa-solid fa-rupiah-sign"></i></a>
            <a id="buttonHapus" class="btn btn-sm buttonHapus btn-warning" value="' . $value->m_rekening_code . '" title="Hapus"><i class="fa fa-trash"></i></a>
            <a id="buttonItem" class="btn btn-sm buttonItem btn-info" value="' . $value->m_rekening_code . '" title="Items"><i class="fa-solid fa-folder"></i></a></div>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function validasinama(Request $request)
    {
        $validasi = DB::table('m_rekening')
            ->where('m_rekening_nama', $request->m_rekening_nama)
            ->where('m_rekening_m_w_id', $request->m_rekening_m_waroeng_id)
            ->count();
        return response()->json($validasi);
    }

    public function validasino(Request $request)
    {
        $validasi = DB::table('m_rekening')
            ->where('m_rekening_code', $request->m_rekening_code)
            ->where('m_rekening_m_w_id', $request->m_rekening_m_waroeng_id)
            ->count();
        return response()->json($validasi);
    }

    public function simpan(Request $request)
    {
        $validasi = DB::table('m_rekening')
            ->select('m_rekening_code')
            ->where('m_rekening_code', $request->m_rekening_code)
            ->count();
        if ($validasi == 0) {
            // $existingTags = json_decode($request->input('existingTags'));
            $m_w_code = $request->m_rekening_m_waroeng_id;
            $m_w_code_val = sprintf("%03d", $m_w_code);
            // return $request->m_rekening_saldo;
            foreach ($request->m_rekening_code as $key => $value) {
                $saldo = str_replace(".", "", $request->m_rekening_saldo[$key]);
                // $str1 = str_replace('.', '', $request->m_rekening_saldo[$key]);
                $data = array(
                    'm_rekening_id' => $this->getMasterId('m_rekening'),
                    'm_rekening_m_w_id' => $request->m_rekening_m_waroeng_id,
                    'm_rekening_m_w_code' => $m_w_code_val,
                    'm_rekening_kategori' => $request->m_rekening_kategori,
                    'm_rekening_code' => $request->m_rekening_code[$key],
                    'm_rekening_nama' => strtolower($request->m_rekening_nama[$key]),
                    'm_rekening_saldo' => $saldo,
                    // 'm_rekening_item' => json_encode($existingTags),
                    'm_rekening_created_by' => Auth::user()->users_id,
                    'm_rekening_created_at' => Carbon::now(),
                );
                // return $data['existing_tags'] = json_encode($existingTags);
                DB::table('m_rekening')->insert($data);
            }
            return response()->json(['messages' => 'Berhasil Menambakan', 'type' => 'success']);
        } else {
            return response()->json(['messages' => 'No Akun Sudah Dipakai', 'type' => 'danger']);
        }

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
                ->where('m_rekening_code', $key->m_rekening_code)
                ->where('m_rekening_nama', $key->m_rekening_nama)
                ->first();
            if (empty($get_data2)) {
                $saldo = ($request->m_rekening_copy_saldo == 'tidak') ? 0 : $key->m_rekening_saldo;
                $data = array(
                    'm_rekening_id' => $this->getMasterId('m_rekening'),
                    'm_rekening_m_waroeng_id' => $request->waroeng_tujuan,
                    'm_rekening_kategori' => $key->m_rekening_kategori,
                    'm_rekening_code' => $key->m_rekening_code,
                    'm_rekening_nama' => $key->m_rekening_nama,
                    'm_rekening_saldo' => $saldo,
                    'm_rekening_created_by' => Auth::user()->users_id,
                    'm_rekening_created_at' => Carbon::now(),
                );
                DB::table('m_rekening')->insert($data);
            }
        }
        return response()->json(['messages' => 'Berhasil copy ke waroeng lain', 'type' => 'success']);
    }

    public function edit($id)
    {
        $data = DB::table('m_rekening')->where('m_rekening_code', $id)->first();
        return response()->json($data);
    }

    public function simpan_edit(Request $request)
    {
        $rekening_old = $request->m_rekening_id;
        $validasi1 = DB::table('rekap_jurnal_kas')
            ->select('rekap_jurnal_kas_m_rekening_code')
            ->where('rekap_jurnal_kas_m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi2 = DB::table('rekap_jurnal_bank')
            ->select('rekap_jurnal_bank_m_rekening_code')
            ->where('rekap_jurnal_bank_m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi3 = DB::table('rekap_jurnal_umum')
            ->select('rekap_jurnal_umum_m_rekening_code')
            ->where('rekap_jurnal_umum_m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi4 = DB::table('m_rekening')
            ->select('m_rekening_code')
            ->where('m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi5 = DB::table('m_rekening')
            ->select('m_rekening_code')
            ->where('m_rekening_nama', $request->m_rekening_nama1)
            ->count();
        if (($validasi4 != 0 && $validasi5 == 0) || ($validasi4 == 0 && $validasi5 != 0)) {
            $validasi4 = 0;
            $validasi5 = 0;
        }

        $validasi = $validasi1 + $validasi2 + $validasi3 + $validasi4 + $validasi5;
        if ($validasi == 0) {
            $str1 = str_replace('.', '', $request->m_rekening_saldo);
            $data = array(
                'm_rekening_code' => $request->m_rekening_code,
                'm_rekening_nama' => $request->m_rekening_nama,
                'm_rekening_saldo' => str_replace(',', '.', $str1),
                'm_rekening_updated_by' => Auth::user()->users_id,
                'm_rekening_updated_at' => Carbon::now(),
            );
            $update = DB::table('m_rekening')->where('m_rekening_code', $rekening_old)
                ->update($data);

            return response()->json([
                'type' => 'success',
                'messages' => 'Data berhasil diupdate',
            ]);
        }
        return response()->json([
            'type' => 'danger',
            'messages' => 'No Akun Sudah Dipakai',
        ]);
    }

    public function item($id)
    {
        $data = DB::table('m_rekening')->select('m_rekening_item', 'm_rekening_code')->where('m_rekening_code', $id)->first();
        return response()->json($data);
    }

    public function simpan_item(Request $request)
    {
        $id_rekening = $request->id;
        $newItem = $request->item;

        $rekening = DB::table('m_rekening')->where('m_rekening_code', $id_rekening)->first();

        if ($rekening) {
            $existingItems = $rekening->m_rekening_item;

            if ($newItem !== null && $newItem !== '') {
                // Menambahkan string baru ke data yang ada
                if (empty($existingItems)) {
                    $updatedItems = $newItem;
                } else {
                    $updatedItems = $existingItems . ',' . $newItem;
                }
            } else {
                // Jika $newItem kosong atau null, maka tidak ada perubahan
                $updatedItems = $existingItems;
            }

            DB::table('m_rekening')->where('m_rekening_code', $id_rekening)
                ->update(['m_rekening_item' => $updatedItems]);

            return response()->json([
                'type' => 'success',
                'messages' => 'Data berhasil diupdate',
            ]);
        } else {
            return response()->json([
                'type' => 'error',
                'messages' => 'Data tidak ditemukan',
            ]);
        }
    }

    public function delete(Request $request, $id)
    {
        $validasi1 = DB::table('rekap_jurnal_kas')
            ->select('rekap_jurnal_kas_m_rekening_code')
            ->where('rekap_jurnal_kas_m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi2 = DB::table('rekap_jurnal_bank')
            ->select('rekap_jurnal_bank_m_rekening_code')
            ->where('rekap_jurnal_bank_m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi3 = DB::table('rekap_jurnal_umum')
            ->select('rekap_jurnal_umum_m_rekening_code')
            ->where('rekap_jurnal_umum_m_rekening_code', $request->m_rekening_code)
            ->count();

        $validasi4 = DB::table('m_link_akuntansi')
            ->select('m_link_akuntansi_m_rekening_code')
            ->where('m_link_akuntansi_m_rekening_code', $request->m_rekening_code)
            ->count();
        $validasi = $validasi1 + $validasi2 + $validasi3 + $validasi4;
        if ($validasi === 0) {
            $delete = DB::table('m_rekening')
                ->where('m_rekening_code', $id)
                ->delete();
            return response()->json([
                'type' => 'success',
                'messages' => 'Data berhasil diupdate',
            ]);
        }
        return response()->json([
            'type' => 'danger',
            'messages' => 'No Akun Sudah Dipakai, tidak bisa dihapus',
        ]);
    }
}
