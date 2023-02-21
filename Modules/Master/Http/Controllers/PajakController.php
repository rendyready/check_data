<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;


class PajakController extends Controller
{
    public function index()
    {
        $data = DB::table('m_pajak')
            ->select('m_pajak_id', 'm_pajak_value')
            ->whereNull('m_pajak_deleted_at')->get();
        return view('master::pajak', compact('data'));
    }
    public function action(Request $request)
    {       $validate = DB::table('m_pajak')->where('m_pajak_value',$request->m_pajak_value)->first();
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    if (!empty($validate)) {
                        return response(['messages' => 'Pajak Duplikat !','type' => 'danger']);
                    } else {
                        $data = array(
                            'm_pajak_id' => $this->getMasterId('m_pajak'),
                            'm_pajak_value'    =>    $request->m_pajak_value,
                            'm_pajak_created_by' => Auth::id(),
                            'm_pajak_created_at' => Carbon::now(),
                        );
                        DB::table('m_pajak')->insert($data);
                        return response(['messages' => 'Berhasil Tambah Pajak !','type' => 'success']);
                    }
                } elseif ($request->action == 'edit') {
                    if (!empty($validate)) {
                        return response(['messages' => 'Pajak Edit Duplikat !','type' => 'danger']);
                    } else {
                        $data = array(
                            'm_pajak_value'    =>    $request->m_pajak_value,
                            'm_pajak_updated_by' => Auth::id(),
                            'm_pajak_updated_at' => Carbon::now(),
                        );
                        DB::table('m_pajak')->where('m_pajak_id', $request->id)
                            ->update($data);
                        return response(['messages' => 'Berhasil Edit Pajak !','type' => 'success']);
                    }
                } else {
                    $softdelete = array('m_pajak_deleted_at' => Carbon::now());
                    DB::table('m_pajak')
                        ->where('m_pajak_id', $request->id)
                        ->update($softdelete);
                }
                return response(['messages' => 'Berhasil Menghapus !','type' => 'success','request'=>$request->all()]);
            }
        
    }
}
