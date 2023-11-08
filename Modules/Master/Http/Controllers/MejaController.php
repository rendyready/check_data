<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use illuminate\Support\Str;
use illuminate\Support\Facades\Validator;

class MejaController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $data->no = 1;
        $data->jenis_meja = DB::table('m_meja_jenis')->get();
        $data->waroeng = DB::table('m_w')->get();
        return view('master::m_meja', compact('data'));
    }
    public function list_meja(){
        $meja = DB::table('m_meja')
        ->leftjoin('m_meja_jenis', 'm_meja_m_meja_jenis_id', 'm_meja_jenis_id')
        ->leftjoin('m_w', 'm_w_id', 'm_meja_m_w_id')
        ->select('m_meja_id','m_meja_nama','m_meja_jenis_nama','m_w_nama')
        ->get();
        $data = [];
        $no =1;
        foreach ($meja as $value) {
            $row = [];
            $row[] = $no++;
            $row[] = $value->m_meja_nama;
            $row[] = $value->m_meja_jenis_nama;
            $row[] = $value->m_w_nama;
            $row[] = '<a class="btn btn-info buttonEdit" value="'.$value->m_meja_id.'" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="'.route("hapus.meja", $value->m_meja_id).'" class="btn btn-danger" title="Delete"><i class="fa fa-trash"></i></a>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function find($id)
    {
        $data = DB::table('m_meja')->where('m_meja_id', $id)->first();
        return response()->json($data, 200);
    }
    public function simpan(Request $request)
    {
        for ($i = $request->mulai_meja; $i <= $request->selesai_meja; $i++) {
            if ($request->m_meja_type == 'meja') {
                $nama = str_pad($i, 2, '0', STR_PAD_LEFT);
            } elseif ($request->m_meja_type == 'bungkus') {
                $nama = 'Bks '.str_pad($i, 2, '0', STR_PAD_LEFT);
            } else {
                $nama = 'Express '.str_pad($i, 2, '0', STR_PAD_LEFT);
            }

            $data = DB::table('m_meja')->insert([
                // "m_meja_id" => $this->getMasterId('m_meja'),
                "m_meja_id" => '1',
                "m_meja_nama" => $nama,
                "m_meja_m_meja_jenis_id" => $request->jenis_meja,
                "m_meja_m_w_id" => $request->waroeng,
                "m_meja_type" => $request->m_meja_type,
                "m_meja_created_by" => Auth::user()->users_id,
                "m_meja_created_at" => Carbon::now(),
            ]);
        }
        return Redirect::route('meja.index');
    }
    public function edit(Request $request)
    {
        DB::table('m_meja')->where('m_meja_id', $request->id_meja)
            ->update([
                "m_meja_nama" => $request->nama_meja,
                "m_meja_m_meja_jenis_id" => $request->jenis_meja,
                "m_meja_m_w_id" => $request->waroeng,
                "m_meja_status_sync" =>'send',
                'm_meja_client_target' => DB::raw('DEFAULT'),
                "m_meja_updated_by" => Auth::user()->users_id,
                "m_meja_updated_at" => Carbon::now(),
            ]);
        return Redirect::route('meja.index');
    }
    public function hapus($id)
    {
        $data = DB::table('m_meja')->where('m_meja_id', '=', $id)->delete();
        return Redirect::route('meja.index');
    }
}
