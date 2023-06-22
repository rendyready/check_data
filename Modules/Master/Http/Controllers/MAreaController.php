<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MArea;
use Carbon\Carbon;
use illuminate\Support\Str;


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
        return view('master::area', compact('data'));
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $aa = Str::lower(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_area_nama));
                // $aa = $request->m_area_nama;
                $aa = str::lower(trim($aa));

                $tb = DB::table('m_area')->selectRaw('m_area_nama')->whereRaw('LOWER(m_area_nama) =' . "'$aa'")->first();

                // Count
                $count = '601';
                $DB = DB::table('m_area')->get()->count('m_area_id');
                if ($DB == 0) {
                     $DBCount = $count;
                } else {
                      $DBCount = '6'.$DB + 1;
                }

                if ($aa == null) {
                    return response(['Messages' => 'Data Tidak Boleh Kosong !','type' => 'danger']);
                } elseif (!empty($tb)) {
                    // return response($this);
                    return response(['Messages' => 'Data Duplikat !','type' => 'danger']);
                } else {
                    if ($tb == null) {
                        DB::table('m_area')->insert([
                            'm_area_id' => $this->getMasterId('m_area'),
                            'm_area_nama'    => Str::lower(trim($request->m_area_nama)),
                            'm_area_code'    => $DBCount,
                            'm_area_created_by' => Auth::user()->users_id,
                            'm_area_created_at' => Carbon::now(),
                        ]);
                        return response(['Messages' => 'Berhasil Tambah Area !','type' => 'success']);
                    } else {
                        return response(['Messages' => 'Data Duplikat !','type' => 'danger']);
                    }
                }
            } elseif ($request->action == 'edit') {
                $ii = Str::lower($request->m_area_nama);
                $trim = trim(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $ii));
                $validate = DB::table('m_area')->selectRaw('m_area_nama')->whereRaw(' LOWER(m_area_nama) =' . "'$trim'")->get();
                $data = array(
                    'm_area_nama'    => Str::lower($trim),
                    'm_area_status_sync' => 'send',
                    'm_area_client_target' => DB::raw('DEFAULT'),
                    'm_area_updated_by' => Auth::user()->users_id,
                    'm_area_updated_at' => Carbon::now(),
                );
                if (!empty($validate)) {
                    DB::table('m_area')->where('m_area_id', $request->id)
                        ->update($data);
                    return response(['Messages' => 'Data Update !','type' => 'success']);
                } else {
                    return response(['Messages' => 'Data Gagal Update !','type' => 'danger']);
                }
            } else {
                $dataRaws = $request->id;
                $RawDelete = DB::table('m_w')->selectRaw('m_w_m_area_id')
                    ->where('m_w_m_area_id', $dataRaws)
                    ->whereNull('m_w_deleted_at')->first();
                if ($RawDelete == null) {
                    $data = array(
                        'm_area_deleted_at' => Carbon::now(),
                        'm_area_deleted_by' => Auth::user()->users_id
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
