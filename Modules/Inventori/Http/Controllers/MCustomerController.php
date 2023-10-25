<?php

namespace Modules\Inventori\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
class MCustomerController extends Controller
{
   /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $waroeng = DB::table('m_w')->get();
        return view('inventori::m_customer', compact('waroeng'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function data()
    {
        $get = DB::table('m_customer')->orderBy('m_customer_id')
            ->whereNull('m_customer_parent_id')
            ->get();
        $no = 0;
        $data = array();
        foreach ($get as $value) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $value->m_customer_code;
            $row[] = $value->m_customer_nama;
            $row[] = $value->m_customer_alamat;
            $row[] = $value->m_customer_telp;
            $row[] = $value->m_customer_ket;
            $row[] = rupiah($value->m_customer_saldo_awal);
            $row[] = $value->m_customer_rek . '-' . $value->m_customer_rek_nama . '-' . $value->m_customer_bank_nama;
            $row[] = '<a id="buttonEdit" class="btn btn-sm buttonEdit btn-success" value="' . $value->m_customer_code . '" title="Edit"><i class="fa fa-pencil"></i></a>';
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
        $code = DB::table('m_customer')->orderBy('m_customer_id', 'desc')->first();
        $nocode = (empty($code->m_customer_code)) ? "500001" : $code->m_customer_code + 1;
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $name = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_customer_nama)));
                $rules = [
                    'm_customer_nama' => 'required|unique:m_customer|max:255',
                ];
                $data_validate = array(
                    'm_customer_nama' => $name,
                );
                $validator = Validator::make($data_validate, $rules, $messages = [
                    'm_customer_nama.required' => 'Nama Belum Terisi',
                    'm_customer_nama.unique' => 'Nama Supplier Duplikat',
                ]);
                if ($validator->fails()) {
                    return response()->json(['messages' => $validator->messages()->all(), 'type' => 'danger']);
                } else {
                    $data = array(
                        'm_customer_code' => $nocode,
                        'm_customer_nama' => $name,
                        'm_customer_jth_tempo' => $request->m_customer_jth_tempo,
                        'm_customer_alamat' => $request->m_customer_alamat,
                        'm_customer_kota' => $request->m_customer_kota,
                        'm_customer_telp' => $request->m_customer_telp,
                        'm_customer_ket' => $request->m_customer_ket,
                        'm_customer_rek' => $request->m_customer_rek,
                        'm_customer_rek_nama' => $request->m_customer_rek_nama,
                        'm_customer_bank_nama' => $request->m_customer_bank_nama,
                        'm_customer_saldo_awal' => $request->m_customer_saldo_awal,
                        'm_customer_created_by' => Auth::user()->users_id,
                        'm_customer_created_at' => Carbon::now(),
                    );
                    DB::table('m_customer')->insert($data);
                    return response(['messages' => 'Berhasil Tambah Supplier !', 'type' => 'success']);
                }
            } elseif ($request->action == 'edit') {
                $name = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_customer_nama)));
                $validate = DB::table('m_customer')
                    ->whereNotIn('m_customer_code', [$request->m_customer_code])
                    ->where('m_customer_nama', $name)
                    ->count();
                if ($validate == 0) {
                    $data = array(
                        'm_customer_nama' => $request->m_customer_nama,
                        'm_customer_jth_tempo' => $request->m_customer_jth_tempo,
                        'm_customer_alamat' => $request->m_customer_alamat,
                        'm_customer_kota' => $request->m_customer_kota,
                        'm_customer_telp' => $request->m_customer_telp,
                        'm_customer_ket' => $request->m_customer_ket,
                        'm_customer_rek' => $request->m_customer_rek,
                        'm_customer_rek_nama' => $request->m_customer_rek_nama,
                        'm_customer_bank_nama' => $request->m_customer_bank_nama,
                        'm_customer_saldo_awal' => $request->m_customer_saldo_awal,
                        'm_customer_status_sync' => 'send',
                        'm_customer_updated_by' => Auth::user()->users_id,
                        'm_customer_updated_at' => Carbon::now(),
                        'm_customer_client_target' => DB::raw('DEFAULT')
                    );
                    DB::table('m_customer')->where('m_customer_code', $request->m_customer_code)
                        ->update($data);
                    return response(['messages' => 'Berhasil Update Supplier !', 'type' => 'success']);
                } else {
                    return response(['messages' => 'Nama Supplier Sudah Ada!', 'type' => 'danger']);
                }
            } elseif ($request->action == 'copy') {
                foreach ($request->m_customer_id as $key => $value) {
                    $code = DB::table('m_customer')->orderBy('m_customer_code', 'desc')->first();
                    $nocode = $code->m_customer_code + 1;
                    $mWId = $request->m_w_id;
                    $supplier_id = $request->m_customer_id[$key];
                    $validate = DB::table('m_customer')
                        ->where('m_customer_parent_id', $supplier_id)
                        ->where('m_customer_m_w_id', $mWId)
                        ->first();
                    $newSaldoAwal = convertfloat($request->m_customer_saldo_awal[$key]);
                    if ($validate) {
                        DB::table('m_customer')
                            ->where('m_customer_parent_id', $supplier_id)
                            ->where('m_customer_m_w_id', $mWId)
                            ->update(['m_customer_saldo_awal' => $newSaldoAwal,
                                'm_customer_updated_by' => Auth::user()->users_id,
                                'm_customer_updated_at' => Carbon::now(),
                                'm_customer_client_target' => DB::raw('DEFAULT')
                            ]);
                    } else {
                        $get_master_supplier = DB::table('m_customer')
                            ->select('m_customer_id', 'm_customer_nama', 'm_customer_jth_tempo',
                                'm_customer_alamat', 'm_customer_kota', 'm_customer_telp', 'm_customer_ket',
                                'm_customer_rek', 'm_customer_rek_nama', 'm_customer_bank_nama')
                            ->where('m_customer_id', $supplier_id)->first();
                        $supplierData = [
                            'm_customer_code' => $nocode,
                            'm_customer_nama' => $get_master_supplier->m_customer_nama,
                            'm_customer_jth_tempo' => $get_master_supplier->m_customer_jth_tempo,
                            'm_customer_alamat' => $get_master_supplier->m_customer_alamat,
                            'm_customer_kota' => $get_master_supplier->m_customer_kota,
                            'm_customer_telp' => $get_master_supplier->m_customer_telp,
                            'm_customer_ket' => $get_master_supplier->m_customer_ket,
                            'm_customer_rek' => $get_master_supplier->m_customer_rek,
                            'm_customer_rek_nama' => $get_master_supplier->m_customer_rek_nama,
                            'm_customer_bank_nama' => $get_master_supplier->m_customer_bank_nama,
                            'm_customer_saldo_awal' => $newSaldoAwal,
                            'm_customer_parent_id' => $supplier_id,
                            'm_customer_m_w_id' => $mWId,
                            'm_customer_created_by' => Auth::user()->users_id,
                            'm_customer_created_at' => Carbon::now(),
                        ];
                        DB::table('m_customer')->insert($supplierData);
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
        $data = DB::table('m_customer')->where('m_customer_code', $id)->first();
        return response()->json($data);
    }

    public function customer_cari_wrg(Request $request)
    {
        $master = DB::table('m_customer')
            ->select('m_customer_id as value', 'm_customer_nama as text')
            ->whereNull('m_customer_parent_id')
            ->whereNotIn('m_customer_id', function ($query) use ($request) {
                $query->select('m_customer_parent_id')
                    ->from('m_customer')
                    ->where('m_customer_m_w_id', $request->w_id);
            })
            ->get();
        $list = DB::table('m_customer')
            ->select('m_customer_parent_id', 'm_customer_nama', 'm_customer_saldo_awal')
            ->whereIn('m_customer_m_w_id', [$request->w_id])
            ->get();

        $listHtml = [];

        foreach ($list as $key) {
            $listHtml[] = [
                'm_customer_nama' => $key->m_customer_nama,
                'm_customer_saldo_awal' => "<input type='hidden' name='m_customer_id[]' value='" . $key->m_customer_parent_id . "'>" .
                "<input class='form-control number' type='text' name='m_customer_saldo_awal[]' value='" . num_format($key->m_customer_saldo_awal) . "'>",
            ];
        }

        $data = [
            'master' => $master,
            'list' => $listHtml,
        ];

        return response()->json($data);
    }
}
