<?php

namespace Modules\Inventori\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng = DB::table('m_w')->get();
        return view('inventori::m_supplier', compact('waroeng'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function data()
    {
        $get = DB::table('m_supplier')->orderBy('m_supplier_id')
            ->whereNull('m_supplier_parent_id')
            ->get();
        $no = 0;
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $no++;
            $row[] = $value->m_supplier_id;
            $row[] = $value->m_supplier_nama;
            $row[] = $value->m_supplier_alamat;
            $row[] = $value->m_supplier_telp;
            $row[] = $value->m_supplier_ket;
            // $row[] = rupiah($value->m_supplier_saldo_awal);
            $row[] = $value->m_supplier_rek_number . '-' . $value->m_supplier_rek_nama . '-' . $value->m_supplier_bank_nama;
            $row[] = '<a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="' . $value->m_supplier_id . '" title="Edit"><i class="fa fa-pencil"></i></a>';
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function action(Request $request)
    {

        if ($request->ajax()) {
            if ($request->action == 'add') {
                $name = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_supplier_nama)));
                $rules = [
                    'm_supplier_nama' => 'required|unique:m_supplier|max:255',
                ];
                $data_validate = array(
                    'm_supplier_nama' => $name,
                );
                $validator = Validator::make($data_validate, $rules, $messages = [
                    'm_supplier_nama.required' => 'Nama Belum Terisi',
                    'm_supplier_nama.unique' => 'Nama Supplier Duplikat',
                ]);
                if ($validator->fails()) {
                    return response()->json(['messages' => $validator->messages()->all(), 'type' => 'danger']);
                } else {
                    $code = DB::table('m_supplier')->orderBy('m_supplier_id', 'desc')
                    ->whereNull('m_supplier_parent_id')->first();
                    $nocode = $code->m_supplier_code + 1;
                    $data = array(
                        'm_supplier_code' => $nocode,
                        'm_supplier_nama' => $name,
                        'm_supplier_jth_tempo' => $request->m_supplier_jth_tempo,
                        'm_supplier_alamat' => $request->m_supplier_alamat,
                        'm_supplier_kota' => $request->m_supplier_kota,
                        'm_supplier_telp' => $request->m_supplier_telp,
                        'm_supplier_ket' => $request->m_supplier_ket,
                        'm_supplier_rek_number' => $request->m_supplier_rek_number,
                        'm_supplier_rek_nama' => $request->m_supplier_rek_nama,
                        'm_supplier_bank_nama' => $request->m_supplier_bank_nama,
                        'm_supplier_created_by' => Auth::user()->users_id,
                        'm_supplier_created_at' => Carbon::now(),
                    );
                    DB::table('m_supplier')->insert($data);
                    return response(['messages' => 'Berhasil Tambah Supplier !', 'type' => 'success']);
                }
            } elseif ($request->action == 'edit') {
                $name = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_supplier_nama)));
                $validate = DB::table('m_supplier')
                    ->whereNotIn('m_supplier_id', [$request->m_supplier_id])
                    ->where('m_supplier_nama', $name)
                    ->count();
                if ($validate == 0) {
                    $data = array(
                        'm_supplier_nama' => $request->m_supplier_nama,
                        'm_supplier_jth_tempo' => $request->m_supplier_jth_tempo,
                        'm_supplier_alamat' => $request->m_supplier_alamat,
                        'm_supplier_kota' => $request->m_supplier_kota,
                        'm_supplier_telp' => $request->m_supplier_telp,
                        'm_supplier_ket' => $request->m_supplier_ket,
                        'm_supplier_rek_number' => $request->m_supplier_rek_number,
                        'm_supplier_rek_nama' => $request->m_supplier_rek_nama,
                        'm_supplier_bank_nama' => $request->m_supplier_bank_nama,
                        'm_supplier_updated_by' => Auth::user()->users_id,
                        'm_supplier_updated_at' => Carbon::now(),
                        'm_supplier_client_target' => DB::raw('DEFAULT'),
                    );
                    DB::table('m_supplier')->where('m_supplier_id', $request->m_supplier_id)
                        ->update($data);
                    return response(['messages' => 'Berhasil Update Supplier !', 'type' => 'success']);
                } else {
                    return response(['messages' => 'Nama Supplier Sudah Ada!', 'type' => 'danger']);
                }
            } elseif ($request->action == 'copy') {
                foreach ($request->m_supplier_id as $key => $value) {
                    $mWId = $request->m_w_id;
                    $supplier_id = $request->m_supplier_id[$key];
                    $validate = DB::table('m_supplier')
                        ->where('m_supplier_parent_id', $supplier_id)
                        ->where('m_supplier_m_w_id', $mWId)
                        ->first();
                    $newSaldoAwal = convertfloat($request->m_supplier_saldo_awal[$key]);
                    if ($validate) {
                        DB::table('m_supplier')
                            ->where('m_supplier_parent_id', $supplier_id)
                            ->where('m_supplier_m_w_id', $mWId)
                            ->update(['m_supplier_saldo_awal' => $newSaldoAwal,
                                'm_supplier_updated_by' => Auth::user()->users_id,
                                'm_supplier_updated_at' => Carbon::now(),
                                'm_supplier_client_target' => DB::raw('DEFAULT'),
                            ]);
                    } else {
                        $get_master_supplier = DB::table('m_supplier')
                            ->select('m_supplier_code','m_supplier_id', 'm_supplier_nama', 'm_supplier_jth_tempo',
                                'm_supplier_alamat', 'm_supplier_kota', 'm_supplier_telp', 'm_supplier_ket',
                                'm_supplier_rek_number', 'm_supplier_rek_nama', 'm_supplier_bank_nama')
                            ->where('m_supplier_id', $supplier_id)->first();
                        $supplierData = [
                            'm_supplier_code' => $get_master_supplier->m_supplier_code,
                            'm_supplier_nama' => $get_master_supplier->m_supplier_nama,
                            'm_supplier_jth_tempo' => $get_master_supplier->m_supplier_jth_tempo,
                            'm_supplier_alamat' => $get_master_supplier->m_supplier_alamat,
                            'm_supplier_kota' => $get_master_supplier->m_supplier_kota,
                            'm_supplier_telp' => $get_master_supplier->m_supplier_telp,
                            'm_supplier_ket' => $get_master_supplier->m_supplier_ket,
                            'm_supplier_rek_number' => $get_master_supplier->m_supplier_rek_number,
                            'm_supplier_rek_nama' => $get_master_supplier->m_supplier_rek_nama,
                            'm_supplier_bank_nama' => $get_master_supplier->m_supplier_bank_nama,
                            'm_supplier_saldo_awal' => $newSaldoAwal,
                            'm_supplier_parent_id' => $supplier_id,
                            'm_supplier_m_w_id' => $mWId,
                            'm_supplier_created_by' => Auth::user()->users_id,
                            'm_supplier_created_at' => Carbon::now(),
                        ];
                        DB::table('m_supplier')->insert($supplierData);
                        return response(['messages' => 'Berhasil Update Supplier !', 'type' => 'success']);
                    }
                }

            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = DB::table('m_supplier')->where('m_supplier_id', $id)->first();
        return response()->json($data);
    }
    
    public function supplier_show($code,$mw_id){
        $data = DB::table('m_supplier')->where('m_supplier_code', $code)
        ->where('m_supplier_m_w_id',$mw_id)
        ->first();
        return response()->json($data);
    }

    public function supplier_cari_wrg(Request $request)
    {
        $master = DB::table('m_supplier')
            ->select('m_supplier_id as value', 'm_supplier_nama as text')
            ->whereNull('m_supplier_parent_id')
            ->whereNotIn('m_supplier_id', function ($query) use ($request) {
                $query->select('m_supplier_parent_id')
                    ->from('m_supplier')
                    ->where('m_supplier_m_w_id', $request->w_id);
            })
            ->get();
        $list = DB::table('m_supplier')
            ->select('m_supplier_parent_id', 'm_supplier_nama', 'm_supplier_saldo_awal')
            ->whereIn('m_supplier_m_w_id', [$request->w_id])
            ->get();

        $listHtml = [];

        foreach ($list as $key) {
            $listHtml[] = [
                'm_supplier_nama' => $key->m_supplier_nama,
                'm_supplier_saldo_awal' => "<input type='hidden' name='m_supplier_id[]' value='" . $key->m_supplier_parent_id . "'>" .
                "<input class='form-control number' type='text' name='m_supplier_saldo_awal[]' value='" . num_format($key->m_supplier_saldo_awal) . "'>",
            ];
        }

        $data = [
            'master' => $master,
            'list' => $listHtml,
        ];

        return response()->json($data);
    }
}
