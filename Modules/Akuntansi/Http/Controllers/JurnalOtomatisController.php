<?php

namespace Modules\Akuntansi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JurnalOtomatisController extends Controller
{
    public function index()
    {
        $waroeng_id = Auth::user()->waroeng_id;
        $data = new \stdClass();
        $data->waroeng_nama = DB::table('m_w')->select('m_w_nama', 'm_w_id')->where('m_w_id', $waroeng_id)->first();
        $data->area_nama = DB::table('m_area')->join('m_w', 'm_w_m_area_id', 'm_area_id')->select('m_area_nama', 'm_area_id')->where('m_w_id', $waroeng_id)->first();
        $data->akses_area = $this->get_akses_area(); //mulai dari 1 - akhir
        $data->akses_pusat = $this->get_akses_pusat(); //1,2,3,4,5
        $data->akses_pusar = $this->get_akses_pusar(); //mulai dari 6 - akhir

        $data->waroeng = DB::table('m_w')
            ->where('m_w_m_area_id', $data->area_nama->m_area_id)
            ->orderby('m_w_id', 'ASC')
            ->get();
        $data->area = DB::table('m_area')
            ->orderby('m_area_id', 'ASC')
            ->get();
        $data->payment = DB::table('m_payment_method')
            ->orderby('m_payment_method_id', 'ASC')
            ->get();
        return view('akuntansi::jurnal_otomatis', compact('data'));
    }

    public function select_waroeng(Request $request)
    {
        $waroeng = DB::table('m_w')
            ->select('m_w_id', 'm_w_nama', 'm_w_code')
            ->where('m_w_m_area_id', $request->id_area)
            ->orderBy('m_w_id', 'asc')
            ->get();
        $data = array();
        foreach ($waroeng as $val) {
            $data[$val->m_w_id] = [$val->m_w_nama];
        }
        return response()->json($data);
    }

    public function tampil_jurnal(Request $request)
    {
        $kas = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Kas Transaksi - cash')
            ->get();
        $nominal = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Nominal Transaksi - cash')
            ->get();
        $pajak = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Pajak Transaksi - cash')
            ->get();
        $sc = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Service Charge Transaksi - cash')
            ->get();
        $tarik = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Tarik Tunai Transaksi - cash')
            ->get();
        $bulat = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Pembulatan Transaksi - cash')
            ->get();
        $diskon = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Diskon Transaksi - cash')
            ->get();
        $persediaan = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Persediaan Transaksi - cash')
            ->get();
        $biaya_persediaan = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Transaksi - cash')
            ->get();
        $kas_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Kas Refund - cash')
            ->get();
        $pajak_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Pajak Refund - cash')
            ->get();
        $sc_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Service Charge Refund - cash')
            ->get();
        $bulat_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Pembulatan Refund - cash')
            ->get();
        $free_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Free Kembalian Refund - cash')
            ->get();
        $sedia_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Persediaan Refund - cash')
            ->get();
        $biaya_sedia_refund = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Refund - cash')
            ->get();
        $sedia_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Persediaan Lostbill')
            ->get();
        $biaya_sedia_lostbill = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Lostbill')
            ->get();
        $sedia_garansi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Persediaan Garansi - cash')
            ->get();
        $biaya_sedia_garansi = DB::table('m_link_akuntansi')
            ->join('m_rekening', 'm_rekening_no_akun', 'm_link_akuntansi_m_rekening_no_akun')
            ->where('m_link_akuntansi_nama', 'Biaya Persediaan Garansi - cash')
            ->get();

        $kas_transaksi = DB::table('rekap_transaksi')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->selectRaw('r_t_tanggal, r_t_id, r_t_nota_code,
                                r_t_nominal as nominal,
                                r_t_nominal_pajak as pajak,
                                r_t_nominal_sc as sc,
                                r_t_nominal_tarik_tunai as tarik,
                                r_t_nominal_free_kembalian as free,
                                r_t_nominal_pembulatan as pembulatan,
                                r_t_nominal_diskon as diskon');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $kas_transaksi->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $kas_transaksi->where('r_t_tanggal', $request->tanggal);
        }

        $kas_transaksi = $kas_transaksi->where('r_p_t_m_payment_method_id', $request->payment)
            ->where('r_t_m_w_id', $request->waroeng)
            ->orderby('r_t_id', 'ASC')
            ->get();

        $refund = DB::table('rekap_refund')
            ->join('rekap_transaksi', 'r_t_id', 'r_r_r_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->selectRaw('r_r_tanggal, r_r_id, r_r_nota_code,
                            r_r_nominal_refund as nominal_refund,
                            r_r_nominal_refund_pajak as pajak_refund,
                            r_r_nominal_refund_sc as sc_refund,
                            r_r_nominal_free_kembalian_refund as free_refund,
                            r_r_nominal_pembulatan_refund as pembulatan_refund');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $refund->whereBetween('r_r_tanggal', [$start, $end]);
        } else {
            $refund->where('r_r_tanggal', $request->tanggal);
        }

        $refund = $refund->where('r_p_t_m_payment_method_id', $request->payment)
            ->where('r_r_m_w_id', $request->waroeng)
            ->orderby('r_r_id', 'ASC')
            ->get();

        $lostbill = DB::table('rekap_lost_bill')
            ->selectRaw('r_l_b_tanggal, r_l_b_id, r_l_b_nota_code,
                        r_l_b_nominal as nominal_lostbill,
                        r_l_b_nominal_pajak as pajak_lostbill,
                        r_l_b_nominal_sc as sc_lostbill');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $lostbill->whereBetween('r_l_b_tanggal', [$start, $end]);
        } else {
            $lostbill->where('r_l_b_tanggal', $request->tanggal);
        }

        $lostbill = $lostbill->where('r_l_b_m_w_id', $request->waroeng)
            ->orderby('r_l_b_id', 'ASC')
            ->get();

        $garansi = DB::table('rekap_garansi')
            ->join('rekap_transaksi', 'r_t_id', 'rekap_garansi_r_t_id')
            ->join('rekap_payment_transaksi', 'r_p_t_r_t_id', 'r_t_id')
            ->selectRaw('r_t_tanggal, rekap_garansi_id, r_t_nota_code,
                        r_t_nominal as nominal');
        if (strpos($request->tanggal, 'to') !== false) {
            [$start, $end] = explode('to', $request->tanggal);
            $garansi->whereBetween('r_t_tanggal', [$start, $end]);
        } else {
            $garansi->where('r_t_tanggal', $request->tanggal);
        }

        $garansi = $garansi->where('r_p_t_m_payment_method_id', $request->payment)
            ->where('r_t_m_w_id', $request->waroeng)
            ->orderby('rekap_garansi_id', 'ASC')
            ->get();

        $data = array();
        foreach ($kas_transaksi as $kasTrans) {
            $processed_ids = array();
            foreach ($kas as $valKas) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->nominal != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'nominal (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->nominal),
                            'kredit' => 0,
                        );
                    }
                    if ($kasTrans->pajak != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'pajak (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->pajak),
                            'kredit' => 0,
                        );
                    }

                    if ($kasTrans->sc != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'sc (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->sc),
                            'kredit' => 0,
                        );
                    }
                    if ($kasTrans->tarik != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->tarik),
                            'kredit' => 0,
                        );
                    }
                    if ($kasTrans->free != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'free kembali (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->free),
                            'kredit' => 0,
                        );
                    }
                    if ($kasTrans->pembulatan != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->pembulatan),
                            'kredit' => 0,
                        );
                    }
                    if ($kasTrans->diskon != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valKas->m_rekening_no_akun,
                            'akun' => $valKas->m_rekening_nama,
                            'particul' => 'diskon (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->diskon),
                            'kredit' => 0,
                        );
                    }
                    $processed_ids[] = $common_id;
                }
            }
            $processed_ids = array();
            foreach ($nominal as $valNominal) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->nominal != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valNominal->m_rekening_no_akun,
                            'akun' => $valNominal->m_rekening_nama,
                            'particul' => 'nominal (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->nominal),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($pajak as $valPajak) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->pajak != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valPajak->m_rekening_no_akun,
                            'akun' => $valPajak->m_rekening_nama,
                            'particul' => 'pajak (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->pajak),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($sc as $valsc) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->sc != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valsc->m_rekening_no_akun,
                            'akun' => $valsc->m_rekening_nama,
                            'particul' => 'sc (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->sc),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($tarik as $valTarik) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->tarik != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valTarik->m_rekening_no_akun,
                            'akun' => $valTarik->m_rekening_nama,
                            'particul' => 'tarik tunai (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->tarik),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($bulat as $valBulat) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->pembulatan != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valBulat->m_rekening_no_akun,
                            'akun' => $valBulat->m_rekening_nama,
                            'particul' => 'pembulatan (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->pembulatan),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($diskon as $valDiskon) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->diskon != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valDiskon->m_rekening_no_akun,
                            'akun' => $valDiskon->m_rekening_nama,
                            'particul' => 'diskon (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->diskon),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($persediaan as $valSedia) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->nominal != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valSedia->m_rekening_no_akun,
                            'akun' => $valSedia->m_rekening_nama,
                            'particul' => 'persediaan (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => 0,
                            'kredit' => number_format($kasTrans->nominal * 0.8),
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
            $processed_ids = array();
            foreach ($biaya_persediaan as $valBiayaSedia) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($kasTrans->nominal != 0) {
                        $data[] = array(
                            'tanggal' => $kasTrans->r_t_tanggal,
                            'no_akun' => $valBiayaSedia->m_rekening_no_akun,
                            'akun' => $valBiayaSedia->m_rekening_nama,
                            'particul' => 'biaya persediaan (nota ' . $kasTrans->r_t_nota_code . ')',
                            'debit' => number_format($kasTrans->nominal * 0.8),
                            'kredit' => 0,
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
        } //transaksi
        foreach ($refund as $valRefund) {
            $processed_ids = array();
            foreach ($kas_refund as $valKasRefund) {
                $common_id = $kasTrans->r_t_id;
                if (!in_array($common_id, $processed_ids)) {
                    if ($valRefund->nominal != 0) {
                        $data[] = array(
                            'tanggal' => $valRefund->r_r_tanggal,
                            'no_akun' => $valKasRefund->m_rekening_no_akun,
                            'akun' => $valKasRefund->m_rekening_nama,
                            'particul' => 'biaya persediaan (nota ' . $valRefund->r_r_nota_code . ')',
                            'debit' => number_format($valRefund->nominal * 0.8),
                            'kredit' => 0,
                        );
                    }
                }
                $processed_ids[] = $common_id;
            }
        } //refund

        $output = array("data" => $data);
        return response()->json($output);
    }

}
