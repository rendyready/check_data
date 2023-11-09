<?php

namespace Modules\Master\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MPlotProduksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use illuminate\Support\Str;

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
        $raw = [
            'm_plot_produksi_nama' => Str::lower($request->m_plot_produski),
        ];
        $val = ['m_plot_produksi_nama' => ['required', 'unique:m_plot_produksi', 'max:255']];
        $validate = Validator::make($raw, $val);
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        } else {
            return response(['Success' => $validate]);
        }
    }
}
