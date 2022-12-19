<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MArea;
use Carbon\Carbon;
use Error;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnValue;

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
        // return $data;
        // $TE = str::lower(trim('pusat               hjghjg         ')); //trim('             PUsAT    lkjhj    ');
        // // $tb = DB::table('m_area')->selectRaw('m_area_nama')->whereRaw('LOWER(m_area_nama) =' . "'$TE'")->get();
        // echo $TE;

        // $value = DB::table('m_area')->whereRaw('LOWER(m_area_nama) =', "{}")->get();
        // $data = DB::table('m_area')->select('m_area_nama')->where(['m_area_nama' => $value])
        //     ->get();
        // $hasil = $data == $pusat;
        // echo $tb;
        // if ($tb == "[]")
        //     echo 'kosong';
        // else
        //     echo 'isi';
        // // var_dump($tb);
        // echo '</pre>';
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $aa = $request->m_area_nama;
                $aa = str::lower(trim($aa));
                $tb = DB::table('m_area')->selectRaw('m_area_nama')->whereRaw('LOWER(m_area_nama) =' . "'$aa'")->first();

                if ($tb == "[]") {
                    $data = DB::table('m_area')->insert([
                        'm_area_nama'    => Str::upper(trim($request->m_area_nama)),
                        'm_area_code'    =>    $request->m_area_code,
                        'm_area_created_by' => Auth::id(),
                        'm_area_created_at' => Carbon::now(),
                    ]);
                    return response(['Messages' => 'Congratulations !']);
                } else {
                    return response(['Messages' => 'Data Duplicate !']);
                }
            } elseif ($request->action == 'edit') {
                $chkEdit = [$request->m_area_nama, $request->m_area_id];
                $validate = DB::table('m_area')->selectRaw('m_area_id' and 'm_area_nama')->whereRaw('m_area_id and LOWER(m_area_nama) =' . "'$chkEdit'")->toSql();
                if ($space == false) {
                    $data = array(
                        'm_area_nama'    =>    $request->m_area_nama,
                        'm_area_code'    =>    $request->m_area_code,
                        'm_area_updated_by' => Auth::id(),
                        'm_area_updated_at' => Carbon::now(),
                    );
                    DB::table('m_area')->where('m_area_id', $request->id)
                        ->update($data);
                    return response(['Messages' => 'Data Update !']);
                } else {
                    return response(['Messages' => true]);
                }
            } else {
                $data = array(
                    'm_area_deleted_at' => Carbon::now(),
                    'm_area_deleted_by' => Auth::id()
                );
                DB::table('m_area')
                    ->where('m_area_id', $request->id)
                    ->update($data);
                return response(['Messages' => 'Data Terhapus !']);
            }
        }
    }
}
