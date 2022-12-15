<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

class MWaroengController extends Controller
{
    public function index()
    {
        $data = DB::table('m_w')
            ->leftjoin('m_area', 'm_w_m_area_id', 'm_area_id')
            ->leftjoin('m_w_jenis', 'm_w_m_w_jenis_id', 'm_w_jenis_id')
            ->leftjoin('m_jenis_nota', 'm_w_m_w_jenis_id', 'm_jenis_nota_m_w_id')
            ->leftjoin('m_pajak', 'm_w_m_pajak_id', 'm_pajak_id')
            ->leftjoin('m_sc', 'm_w_m_sc_id', 'm_sc_id')
            ->leftjoin('m_modal_tipe', 'm_w_m_modal_tipe_id', 'm_modal_tipe_id')
            ->select(
                'm_w_id',
                'm_w_nama',
                'm_w_alamat',
                'm_area_nama',
                'm_w_status',
                'm_w_jenis_nama',
                'm_w_m_kode_nota',
                'm_pajak_value',
                'm_sc_value',
                'm_modal_tipe_nama'
            )
            ->get();
        return view('master::m_waroeng', compact('data'));

        return $data;
    }
    public function list()
    {
        $data = new \stdClass();
        $area = DB::table('m_area')->select('m_area_id', 'm_area_nama')->get();
        $jenisw = DB::table('m_w_jenis')->select('m_w_jenis_id', 'm_w_jenis_nama')->get();
        $modalt = DB::table('m_modal_tipe')->select('m_modal_tipe_id', 'm_modal_tipe_nama')->get();
        $jenisn = DB::table('m_jenis_nota')->select('m_jenis_nota_id', 'm_jenis_nota_m_w_id', 'm_jenis_nota_m_t_t_id')->get();
        $pajak = DB::table('m_pajak')->select('m_pajak_id', 'm_pajak_value')->get();
        $sc = DB::table('m_sc')->select('m_sc_id', 'm_sc_value')->get();
        foreach ($area as $key => $v) {
            $data->area[$v->m_area_id] = $v->m_area_nama;
        }
        foreach ($jenisw as $key => $v) {
            $data->jenisw[$v->m_w_jenis_id] = $v->m_w_jenis_nama;
        }
        foreach ($modalt as $key => $v) {
            $data->modalt[$v->m_modal_tipe_id] = $v->m_modal_tipe_nama;
        }
        foreach ($jenisn as $key => $v) {
            $data->jenisn[$v->m_jenis_nota_id] = $v->m_jenis_nota_m_w_id;
            $data->jenisn[$v->m_jenis_nota_id] = $v->m_jenis_nota_m_t_t_id;
        }
        foreach ($pajak as $key => $v) {
            $data->pajak[$v->m_pajak_id] = $v->m_pajak_value;
        }
        foreach ($sc as $key => $v) {
            $data->sc[$v->m_sc_id] = $v->m_sc_value;
        }
        return response()->json($data);
    }
    public function action(Request $request)
    {
        $raw = [
            'm_w_nama' => Str::lower($request->m_w_nama),
            'm_w_alamat' => Str::lower($request->m_w_alamat),
        ];
        $val = [
            'm_w_nama' => ['required',  'unique:m_w', 'max:255'],
            'm_w_alamat' => ['required'],
        ];
        $validate = Validator::make($raw, $val);
        if ($validate->fails()) {
            return response()->json(['Message' => 'Data Duplicate']);
        } else {
            if ($validate->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_w_nama' => Str::lower($request->m_w_nama),
                        // 'm_w_code' => $request->m_w_code->NULL,
                        'm_w_m_area_id' => $request->m_w_m_area_id,
                        'm_w_m_w_jenis_id' => $request->m_w_m_w_jenis_id,
                        'm_w_status' => $request->m_w_status,
                        'm_w_alamat' => Str::lower($request->m_w_alamat),
                        'm_w_m_kode_nota' => $request->m_w_m_kode_nota,
                        'm_w_m_pajak_id' => $request->m_w_m_pajak_id,
                        'm_w_m_modal_tipe_id' => $request->m_w_m_modal_tipe_id,
                        'm_w_m_sc_id' => $request->m_w_m_sc_id,
                        'm_w_decimal' => $request->m_w_decimal,
                        'm_w_pembulatan' => $request->m_w_pembulatan,
                        'm_w_currency' => $request->m_w_cuurency,
                        'm_w_grab' => $request->m_w_grab,
                        'm_w_gojek' => $request->m_w_gojek,
                        'm_menu_profit' => $request->m_menu_profit,
                        'm_w_created_by' => Auth::id(),
                        'm_w_created_at' => Carbon::now(),
                    );
                    DB::table('m_w')->whereNull(['m_w_code' => $request->m_w_code])->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_w_nama'    =>    $request->m_w_nama,
                        'm_w_alamat'    =>    $request->m_w_alamat,
                        'm_w_m_area_id' => $request->m_w_m_area_id,
                        'm_w_m_w_jenis_id' => $request->m_w_m_w_jenis_id,
                        'm_w_m_pajak_id' => $request->m_w_m_pajak_id,
                        'm_w_m_sc_id' => $request->m_w_m_sc_id,
                        'm_w_m_jenis_nota_id' => $request->m_w_m_jenis_nota_id,
                        'm_w_m_modal_tipe_id' => $request->m_w_m_modal_tipe_id,
                        'm_w_updated_by' => Auth::id(),
                        'm_w_updated_at' => Carbon::now(),
                    );
                    DB::table('m_w')->where('m_w_id', $request->m_w_id)
                        ->update($data);
                } else {
                    $softdelete = array('m_w_deleted_at' => Carbon::now());
                    DB::table('m_pajak')
                        ->where('m_w_id', $request->m_w_id)
                        ->update($softdelete);
                }
                // return response(['Success' => $data]);
            }
        }
    }

    public function create()
    {
        return view('master::MastersCreate.MWaroengCreate');
    }
}
