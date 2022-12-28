<?php

namespace Modules\Learn\Http\Controllers;

use App\Models\MLevelJabatan;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use illuminate\Support\Str;

class MJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = MLevelJabatan::select(
            'm_level_jabatan_id',
            'm_level_jabatan_nama'
        )
            ->whereNull('m_level_jabatan_deleted_at')
            ->orderBy('m_level_jabatan_id')
            ->get();
        return view('learn::m_jabatan', compact('data'));
    }
    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $raw = $request->m_level_jabatan_nama;
                $jabatan = DB::table('m_level_jabatan')->selectRaw('m_level_jabatan_nama')
                    ->whereRaw('LOWER(m_level_jabatan_nama)=' . "'$raw'")
                    ->whereNull('m_level_jabatan_deleted_at')
                    ->first();
                if (!empty($jabatan)) {
                    return response(['Messages' => 'Data Update Kosong !']);
                } elseif ($jabatan == null) {
                    $data = array(
                        'm_level_jabatan_nama' => $raw,
                        'm_level_jabatan_created_by' => Auth::id(),
                        'm_level_jabatan_created_at' => Carbon::now(),
                    );
                    DB::table('m_level_jabatan')
                        ->insert($data);
                    return response(['Messages' => 'Data Berhasil Update !']);
                } elseif ($jabatan) {
                    return response(['Messages' => 'Data Jabatan Double !']);
                }
            } elseif ($request->action == 'edit') {
                $raw = Str::upper(preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $request->m_level_jabatan_nama));
                $jabatan = DB::table('m_level_jabatan')->selectRaw('m_level_jabatan_nama')
                    ->whereRaw('LOWER(m_level_jabatan_nama)=' . "'$raw'")
                    ->whereNull('m_level_jabatan_deleted_at')
                    ->first();
                if (!empty($raw == false)) {
                    // redirect()->route('level-jabatan.action');
                    return response(['Messages' => 'Data Edit Kosong !', $raw]);
                } elseif ($jabatan == true) {
                    // redirect()->route('level-jabatan.action');
                    return response(['Messages' => 'Data Edit Duplicate !', $jabatan]);
                } elseif ($jabatan == false) {
                    // $data = array(
                    //     'm_level_jabatan_nama' => $request->m_level_jabatan_nama,
                    //     'm_level_jabatan_updated_by' => Auth::id(),
                    //     'm_level_jabatan_updated_at' => Carbon::now(),
                    // );
                    // DB::table('m_level_jabatan')
                    //     ->where('m_level_jabatan_id', $request->m_level_jabatan_id)
                    //     ->update($data);
                    // redirect()->route('level-jabatan.action');
                    return response(['Messages' => 'Data Edit Bisa Update!', $jabatan]);
                }

                // return response()->json($data);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('learn::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('learn::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('learn::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        if ($request->ajax())
            if ($request->action == 'delete') {
                $deleted_at = array('m_level_jabatan_deleted_at' => Carbon::now());

                $data = MLevelJabatan::find('m_level_jabatan_id', $request->m_level_jabatan_id);
                $data->where('m_level_jabatan_nama', 'm_level_jabatan_deleted_at');
                $data->delete($deleted_at);

                return response()->json($request);
            }
    }
}
