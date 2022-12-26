<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MArea;
use Carbon\Carbon;
use illuminate\Support\Str;
use illuminate\Support\Facades\Validator;

use function Symfony\Component\VarDumper\Dumper\esc;

class MAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MArea::select('m_area_id', 'm_area_nama', 'm_area_code')->whereNull('m_area_deleted_at')->orderBy('m_area_id', 'asc')->get();
        // return view('master::area', compact('data'));

        $ss = 2;
        $name = 'Purwokerto';
        $idCheck = DB::table('m_area')
            ->select('m_area_id', 'm_area_nama')
            ->where(['m_area_id' => $ss], ['m_area_nama' => $name])
            ->first();

        if ($idCheck == [$ss, $name]) {
            // DB::table('m_area_nama')->select('m_area_nama')->where(['m_area_id', 'm_area_nama'])->get();
            return response(['data' => $this]);
        } elseif ($idCheck) {
            return ['Errors' => $idCheck];
        }

        // return  response()->json($idCheck);
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $aa = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_area_nama));
                $aa = str::lower(trim($aa));
                $tb = DB::table('m_area')->selectRaw('m_area_nama')->whereRaw('LOWER(m_area_nama) =' . "'$aa'")->first();

                // Count
                $count = '600';
                $DB = DB::table('m_area')->count('m_area_id');
                $areaCode = $count + $DB + 1;

                if (!empty($aa == null)) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !']);
                } elseif ($tb == true) {
                    // return response($this);
                    return response(['Messages' => 'Data Duplicate !']);
                } else {
                    $data = DB::table('m_area')->insert([
                        'm_area_nama'    => $aa,
                        'm_area_code'    => $areaCode,
                        'm_area_created_by' => Auth::id(),
                        'm_area_created_at' => Carbon::now(),
                    ]);
                    return response(['Messages' => 'Data Area Update !']);
                }
            } elseif ($request->action == 'edit') {
                $chkEdit = $request->m_area_nama;
                $chkEdit = Str::lower($chkEdit);
                $validate = DB::table('m_area')->selectRaw('m_area_nama')
                    ->whereRaw(' LOWER(m_area_nama) =' . "'$chkEdit'")
                    ->get();

                $ii = Str::upper($request->m_area_nama);
                $trim = trim(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $ii));

                // Return Insert Data
                $data = array(
                    'm_area_nama'    => $trim,
                    'm_area_code'    => $request->m_area_code,
                    'm_area_updated_by' => Auth::id(),
                    'm_area_updated_at' => Carbon::now(),
                );
                if ($validate == null) {
                    DB::table('m_area')->select('m_area_id', $request->id)->where('m_area_id', $request->id)
                        ->update($data);
                    return $data;
                    return response(['Messages' => 'Data Update !']);
                } else {
                    return response(['Messages' => 'Data Gagal Update !']);
                }
            } else {
                $dataRaws = $request->id;
                $RawDelete = DB::table('m_w')->select('m_w_m_area_id')
                    ->where('m_w_m_area_id', $dataRaws)
                    ->whereNull('m_w_deleted_at')->first();
                if ($RawDelete == null) {
                    $data = array(
                        'm_area_deleted_at' => Carbon::now(),
                        'm_area_deleted_by' => Auth::id()
                    );
                    DB::table('m_area')
                        ->where('m_area_id', $request->id)
                        ->update($data);
                    return response(['Messages' => 'Data Terhapus !']);
                } elseif ($RawDelete == $RawDelete) {
                    return response(['Messages' => 'Data Ada Tidak Bisa Hapus !']);
                }
            }
        }
    }
}
