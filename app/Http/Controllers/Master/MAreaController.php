<?php

namespace App\Http\Controllers\Master;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       
        return view('master.area');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_area()
    {
        $area = area::where('area_awal', 'Y')->with('get_barangsokeu')->orderBy('area_id', 'asc')->get();
        $no = 0;
        $data = array();
        foreach($area as $list){
            $sat = $list->get_barangsokeu->id_satuan;
            $satuan = Satuan::where('id_satuan', '=', $sat)->first();
            $dt_satuan = $satuan['nm_satuan'];
            $no ++;
            $row = array();

            $row[] = $no;
            $row[] = tanggal_indonesia($list->area_tgl);
            $row[] = "Stock Awal";
            $row[] = $list->get_barangsokeu->barangsokeu_nm;
            $row[] = $list->area_stk." ".$dt_satuan;
            if ($list->area_stk === 0){
                $row[] = '<div class="btn-group">
                <a onclick="editForm('.$list->area_id.')" class="btn yellow-lemon btn-sm"><i class="fa fa-pencil"></i></a>
                </div>';
            } else {
                $row[] = "-";
            }

            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
