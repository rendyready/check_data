<?php

namespace Modules\Hrd\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use App\Models\{
    MDivisi,
};
use Illuminate\Support\Facades\DB;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $query = "
        SELECT m.id,m.m_divisi_id,m.m_divisi_name, m.m_divisi_parent_id,
(SELECT d.m_divisi_name FROM m_divisi d where d.m_divisi_id = m.m_divisi_parent_id) parent 
FROM m_divisi m
        ";

        $data['divisi'] = DB::select($query);
        $data['parent'] = MDivisi::where('m_divisi_parent_id',NULL)->get();
        return view('hrd::divisi', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('hrd::create');
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
        $data = MDivisi::where('m_divisi_id',$id)->first();
        return response($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('hrd::edit');
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

    public function getParent()
    {
        $getParent = MDivisi::where('m_divisi_parent_id',NULL)->get();
        return $getParent;
    }
}
