<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MPlotProduksi;
use Illuminate\Http\Request;

class MPlotProduksiController extends Controller
{
    public function index(){

        $plot=MPlotProduksi::all();
        
        return view('master.plot');
    }
}
