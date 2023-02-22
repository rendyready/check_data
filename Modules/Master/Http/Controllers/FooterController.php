<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class FooterController extends Controller
{
    public function index()
    {
        $data = DB::table('m_footer')
            ->leftjoin('m_w', 'm_footer_m_w_id', 'm_w_id')
            ->select('m_footer_id', 'm_footer_value', 'm_footer_priority', 'm_w_nama')
            ->get();
        return view('master::conf_footer', compact('data'));
    }
    public function action(Request $request)
    {

        $m_footer_value = trim(strtolower(preg_replace('!\s+!', ' ', $request->m_footer_value)));
        $rules = [
            'm_footer_value' => 'required|max:255',
            'm_footer_priority' => 'required',
            'm_footer_m_w_id' => 'required'
        ];
        $data_validate = array(
            'm_footer_value' =>  $m_footer_value,
            'm_footer_priority' =>    $request->m_footer_priority,
            'm_footer_m_w_id' => $request->m_footer_m_w_id,
        );
        $validator = Validator::make($data_validate, $rules, $messages = [
            'm_footer_value.required' => 'Keterangan Belum Terisi',
            'm_footer_value.max' => 'Maksimal 255 Karakter Terpenuhi !',
            'm_footer_priority.required' => 'Urutan Belum Terisi',
            'm_footer_m_w_id.required' => 'Waroeng Belum Terisi'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->messages()->all(),'type'=>'danger']);
        } else {
            if ($request->ajax()) {
                if ($request->action == 'add') {
                    $data = array(
                        'm_footer_id' => $this->getMasterId('m_footer'),
                        'm_footer_value'    =>    $request->m_footer_value,
                        'm_footer_m_w_id' =>    $request->m_footer_m_w_id,
                        'm_footer_priority' =>    $request->m_footer_priority,
                        'm_footer_created_by' => Auth::id(),
                        'm_footer_created_at' => Carbon::now(),
                    );
                    DB::table('m_footer')->insert($data);
                } elseif ($request->action == 'edit') {
                    $data = array(
                        'm_footer_value'    =>    $request->m_footer_value,
                        'm_footer_m_w_id' =>    $request->m_footer_m_w_id,
                        'm_footer_priority' =>    $request->m_footer_priority,
                        'm_footer_updated_by' => Auth::id(),
                        'm_footer_updated_at' => Carbon::now(),
                    );
                    DB::table('m_footer')->where('m_footer_id', $request->m_footer_id)
                        ->update($data);
                } else {
                    $softdelete = array('m_footer_deleted_at' => Carbon::now());
                    DB::table('m_footer')
                        ->where('m_footer_id', $request->m_footer_id)
                        ->update($softdelete);
                }
                return response()->json(['error'=>['Berhasil'],'type'=>'success']);
            }
        }
    }
    public function list()
    {
        $data = new \stdClass();
        $w = DB::table('m_w')->select('m_w_id', 'm_w_nama')->get();
        foreach ($w as $key => $v) {
            $data->mw[$v->m_w_id] = $v->m_w_nama;
        }
        return response()->json($data);
    }
}
