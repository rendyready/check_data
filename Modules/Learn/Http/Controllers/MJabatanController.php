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
use illuminate\Support\Facades\Validator;

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


    // Action
    public function action(Request $request)
    {
        // $validate = Validator::make(
        //     $request->all(),
        //     ['m_level_jabatan_nama' => ['required', 'unique:m_level_jabatan']],
        //     ['m_level_jabatan_nama.required' => 'Data Tidak Boleh Kosong !']
        // );

        if ($request->ajax()) {
            $raw = Str::lower($request->m_level_jabatan_nama);
            $dataRaw = DB::table('m_level_jabatan')->whereRaw("LOWER(m_level_jabatan_nama)='{$raw}'")->first();
            if (!empty($dataRaw->m_level_jabatan_nama)) {
                Validator::make($request->all(), [
                    ['m_level_jabatan_nama' => ['required', 'unique:m_level_jabatan']],
                    ['m_level_jabatan_nama.required' => 'Data Tidak Boleh Kosong !']

                ])->validate();
                if ($request->fails()) {
                    return response()->json([$this->$request]);
                } else {
                    return response()->json([
                        'success' => $request, 'errors' => $request
                    ]);
                }
            }

            return $this;

            if ($request->action == 'add') {
                $data = array(
                    'm_level_jabatan_id' => $request->m_level_jabatan_id,
                    'm_level_jabatan_nama' => $request->m_level_jabatan_nama,
                    'm_level_jabatan_created_by' => Auth::id(),
                    'm_level_jabatan_created_at' => Carbon::now(),
                );
                DB::table('m_level_jabatan')
                    ->select('m_level_jabatan_id')
                    ->where('m_level_jabatan_nama')
                    ->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_level_jabatan_id' => $request->m_level_jabatan_id,
                    'm_level_jabatan_nama' => $request->m_level_jabatan_nama,
                    'm_level_jabatan_updated_by' => Auth::id(),
                    'm_level_jabatan_updated_at' => Carbon::now(),
                );
                DB::table('m_level_jabatan')
                    ->where('m_level_jabatan_id', $request->m_level_jabatan_id)
                    // ->where('m_level_jabatan_nama')
                    ->update($data);
                return response()->json($request);
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
