<?php

namespace Modules\Learn\Http\Controllers;

use App\Models\MPlotProduksi;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MPlotProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = MPlotProduksi::select('m_plot_produksi_id', 'm_plot_produksi_nama')
            ->whereNull('m_plot_produksi_deleted_at')
            ->orderBy('m_plot_produksi_id', 'asc')
            ->get();
        return view('learn::m_plot_produksi', compact('data'));
    }


    // Action
    public function action(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'add') {
                $data = array(
                    'm_plot_produksi_id' => $request->m_plot_produksi_id,
                    'm_plot_produksi_nama' => $request->m_plot_produksi_nama,
                    'm_plot_produksi_created_by' => Auth::id(),
                    'm_plot_produksi_created_at' => Carbon::now(),
                );
                DB::table('m_plot_produksi')
                    ->where('m_plot_produksi_nama')
                    ->insert($data);
            } elseif ($request->action == 'edit') {
                $data = array(
                    'm_plot_produksi_nama' => $request->m_plot_produksi_nama,
                    'm_plot_produksi_updated_by' => Auth::id(),
                    'm_plot_produksi_updated_at' => Carbon::now(),
                );
                DB::table('m_plot_produksi')->where('m_plot_produksi_id', $request->m_plot_produksi_id)
                    ->update($data);
            } elseif ($request->action == 'delete') {
                $data = MPlotProduksi::where('m_plot_produksi_id');
                $data->delete();
            }
        }
        return response()->json();
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
    public function destroy($id)
    {
        //
    }
}
