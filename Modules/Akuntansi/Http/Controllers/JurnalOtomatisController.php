<?php

namespace Modules\Akuntansi\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class JurnalOtomatisController extends Controller
{
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area();//mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat();//1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        return view('akuntansi::jurnal_otomatis', compact('data'));
    }

    public function tampil_jurnal(Request $request)
    {
        $jurnal = DB::table('rekap_transaksi')
                ->selectRaw('r_t_tanggal, SUM(r_t_nominal_total_bayar) as total');
                if (strpos($request->tanggal, 'to') !== false) {
                    [$start, $end] = explode('to', $request->tanggal);
                    $jurnal->whereBetween('r_t_tanggal', [$start, $end]);
                } else {
                    $jurnal->where('r_t_tanggal', $request->tanggal);
                }
                $jurnal = $jurnal->where('r_t_m_w_id', $request->waroeng)
                ->groupby('r_t_tanggal')
                ->orderby('r_t_tanggal', 'ASC')
                ->get();

        $data = array();
        foreach($jurnal as $valJurnal) {
            $row = array();
            $row[] = date('d-m-Y', strtotime($valJurnal->r_t_tanggal));
            $row[] = number_format($valJurnal->total);
            $row[] ='<a id="button_pdf" class="btn btn-sm button_pdf btn-info" value="'.$valJurnal->r_t_tanggal.'" title="Jurnal"><i class="fa-sharp fa-solid fa-eye"></i></a>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function export_pdf(Request $request)
    {
        $jurnal = DB::table('rekap_transaksi')
                ->selectRaw('r_t_tanggal, SUM(r_t_nominal_total_bayar) as total')
                ->where('r_t_tanggal', $request->tanggal)
                ->where('r_t_m_w_id', Auth::user()->waroeng_id)
                ->groupby('r_t_tanggal')
                ->orderby('r_t_tanggal', 'ASC')
                ->get();

        foreach($jurnal as $valJurnal){
            $data[] = array(
                'tanggal' => number_format($valJurnal->r_t_tanggal),
                'akun' => number_format($valJurnal->rekap_modal_cash_in),
                'debit' => number_format($valJurnal->rekap_modal_cash_out),
                'kredit' => number_format($valJurnal),
                // 'payment' => 22,
            );
        }

        $tgl = tgl_indo($request->tanggal);
        $user = DB::table('users')
                ->where('waroeng_id', $request->waroeng)
                ->first();
        $kasir = $user->name;
        $kacab = DB::table('history_jabatan')
            ->where('history_jabatan_m_w_code',$request->waroeng)
            ->first();
        $pdf = pdf::loadview('dashboard::jurnal_otomatis_pdf',compact('data','tgl','w_nama','kacab'))->setPaper('a4');
        return $pdf->download('jurnal'.strtolower($tgl).'_.pdf');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('akuntansi::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('akuntansi::edit');
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
