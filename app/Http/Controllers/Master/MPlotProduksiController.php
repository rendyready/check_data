<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MPlotProduksi;
use Illuminate\Http\Request;

class MPlotProduksiController extends Controller
{
    public function index()
    {

        $plot = MPlotProduksi::select('id', 'm_plot_produksi_nama')->orderBy('id', 'asc')->get();

        return view('master.plot', compact('plot'));
        // dd($plot);

    }
    //actions
    function action(Request $request){
        if ($request->ajax())
        {
            $data= MPlotProduksi::all();
            return datatables()->of($data)->addColumn(
                'action' function ($row){
                    $text = '<a href="#" class="btn btn-xs btn-secondary btn-edit">';
                    $text = '<button data-rowid="'.$row->. '"class="btn btn-xs btn-danger btn-delete">Delete</button>';
                    return $text;

                }) ->toJson();
        }
        return view('master.plot');
    }   

    
   
}
