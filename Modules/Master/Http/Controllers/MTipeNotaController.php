<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MTipeNotaController extends Controller
{
    public function index()
    {
        $data = DB::table('m_tipe_nota')->whereNull('m_tipe_nota_deleted_at')->orderBy('m_tipe_nota_id', 'asc')->get();
        return view('master::m_tipe_nota', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            $DBjenisNama = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_tipe_nota_nama));
            $jenisNama = Str::lower(trim($DBjenisNama));
            $DBJenisWaroeng = DB::table('m_tipe_nota')->selectRaw('m_tipe_nota_nama')
                ->whereRaw('LOWER(m_tipe_nota_nama)' . '=' . "'$jenisNama'")->first();
            if ($request->action == 'add') {
                if (!empty($DBjenisNama == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !' , 'type' => 'danger']);
                } elseif ($DBJenisWaroeng == true) {
                    return response(['Messages' => 'Data Duplicate !', 'type' => 'danger']);
                } else {
                    $data = array(
                        'm_tipe_nota_id' => $this->getMasterId('m_tipe_nota'),
                        'm_tipe_nota_nama' => $DBjenisNama,
                        'm_tipe_nota_created_by' => Auth::user()->users_id,
                        'm_tipe_nota_created_at' => Carbon::now(),
                    );
                    DB::table('m_tipe_nota')->insert($data);
                    return response(['Messages' => 'Data Tipe Nota Input !', 'type' => 'success']);
                }
            } elseif ($request->action == 'edit') {
                if (!empty($DBjenisNama == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !', 'type' => 'danger']);
                } elseif ($DBJenisWaroeng == true) {
                    return response(['Messages' => 'Data Duplicate !', 'type' => 'danger']);
                } else {
                    $data = array(
                        'm_tipe_nota_id' => $request->m_tipe_nota_id,
                        'm_tipe_nota_nama' => $DBjenisNama,
                        'm_tipe_nota_updated_by' => Auth::user()->users_id,
                        'm_tipe_nota_updated_at' => Carbon::now(),
                    );
                    DB::table('m_tipe_nota')->where('m_tipe_nota_id',$request->m_tipe_nota_id)->update($data);
                    return response(['Messages' => 'Data Tipe Nota Update !', 'type' => 'success']);
                }
            }
        }
    }
}
