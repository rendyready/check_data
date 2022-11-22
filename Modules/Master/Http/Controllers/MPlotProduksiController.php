<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MPlotProduksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MPlotProduksiController extends Controller
{
    public function index()
    {

        $plot = MPlotProduksi::select('id', 'm_plot_produksi_nama')->orderBy('id', 'asc')->get();

        return view('master::plot', compact('plot'));
        // dd($plot);

    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->select(
            'm_plot_produksi_nama'
        ))->validate();
    }
}
