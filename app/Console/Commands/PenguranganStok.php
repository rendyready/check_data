<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\JangkrikHelper;

class PenguranganStok extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pengurangan:stok';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengurangan persediaan otomatis dari penjualan';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Cron Job Pengurangan Stok START at ". Carbon::now()->format('Y-m-d H:i:s'));
        #Log Info
        $get_trans = DB::table('log_transaksi_cr')->limit(10)->get();

        foreach ($get_trans as $key) {
            $get_trans_m_w = DB::table('rekap_transaksi')->where('r_t_id', $key->log_transaksi_cr_r_t_id)->value('r_t_m_w_id');
            $get_user_id = DB::table('rekap_transaksi')->where('r_t_id', $key->log_transaksi_cr_r_t_id)->value('r_t_created_by');
            $get_trans_detail = DB::table('rekap_transaksi_detail')
                ->join('m_produk', 'r_t_detail_m_produk_code', 'm_produk_code')
                ->where('r_t_detail_r_t_id', $key->log_transaksi_cr_r_t_id)
                ->get();

            foreach ($get_trans_detail as $val) {
                // ke wbd
                if ($val->m_produk_scp == 'ya' &&
                    $val->m_produk_hpp == 'sales' &&
                    $val->m_produk_m_jenis_produk_id == 11) {

                    $get_gudang_code = DB::table('m_gudang')
                        ->where('m_gudang_nama', 'gudang wbd waroeng')
                        ->where('m_gudang_m_w_id', $get_trans_m_w)->value('m_gudang_code');
                    $get_stok = JangkrikHelper::get_last_stok($get_gudang_code, $val->r_t_detail_m_produk_code);
                    $update_stok = DB::table('m_stok')
                        ->where('m_stok_gudang_code', $get_gudang_code)
                        ->where('m_stok_m_produk_code', $val->r_t_detail_m_produk_code)
                        ->update([
                            'm_stok_saldo' => $get_stok->m_stok_saldo - $val->r_t_detail_qty,
                            'm_stok_keluar' => $get_stok->m_stok_keluar + $val->r_t_detail_qty,
                            'm_stok_updated_at' => Carbon::now(),
                        ]);
                    $stok_detail = [
                        'm_stok_detail_id' => JangkrikHelper::getNextIdCron('m_stok_detail', $get_trans_m_w, $get_user_id),
                        'm_stok_detail_tgl' => Carbon::now(),
                        'm_stok_detail_m_produk_code' => $val->r_t_detail_m_produk_code,
                        'm_stok_detail_m_produk_nama' => $get_stok->m_stok_produk_nama,
                        'm_stok_detail_satuan_id' => $get_stok->m_stok_satuan_id,
                        'm_stok_detail_satuan' => $get_stok->m_stok_satuan,
                        'm_stok_detail_gudang_code' => $get_gudang_code,
                        'm_stok_detail_keluar' => convertfloat($val->r_t_detail_qty),
                        'm_stok_detail_saldo' => $get_stok->m_stok_saldo - convertfloat($val->r_t_detail_qty),
                        'm_stok_detail_hpp' => $get_stok->m_stok_hpp,
                        'm_stok_detail_catatan' => 'penjualan cr ' . $key->log_transaksi_cr_r_t_id,
                        'm_stok_detail_created_by' => 1,
                        'm_stok_detail_created_at' => Carbon::now(),
                    ];
                    DB::table('m_stok_detail')->insert($stok_detail);

                } else {
                    $get_resep = DB::table('m_resep')
                        ->join('m_resep_detail', 'm_resep_code', 'm_resep_detail_m_resep_code')
                        ->where('m_resep_m_produk_code', $val->r_t_detail_m_produk_code)
                        ->get();

                    foreach ($get_resep as $val2) {
                        if ($val->m_produk_scp == 'ya' && $val->m_produk_hpp == 'scp') {
                            $get_std_resep = DB::table('m_std_bb_resep')
                                ->where('m_std_bb_resep_m_produk_code_asal', $val2->m_resep_detail_bb_code)
                                ->where('m_std_bb_resep_gudang_status', 'produksi')
                                ->first();

                            if (!empty($get_std_resep)) {
                                $qty = ($val->r_t_detail_qty * $val2->m_resep_detail_bb_qty) / convertfloat($get_std_resep->m_std_bb_resep_qty);
                                $bb = $get_std_resep->m_std_bb_resep_m_produk_code_relasi;
                            } elseif (!empty($val2->m_resep_detail_standar_porsi)) {
                                $qty = $val->r_t_detail_qty / $val2->m_resep_detail_standar_porsi;
                                $bb = $val2->m_resep_detail_bb_code;
                            } else {
                                continue;
                            }
                            $qty = number_format($qty, 2);
                            $get_gudang_code = DB::table('m_gudang')
                                ->where('m_gudang_nama', 'gudang produksi waroeng')
                                ->where('m_gudang_m_w_id', $get_trans_m_w)->value('m_gudang_code');
                            $get_stok = JangkrikHelper::get_last_stok($get_gudang_code, $bb);
                            $update_stok = DB::table('m_stok')
                                ->where('m_stok_gudang_code', $get_gudang_code)
                                ->where('m_stok_m_produk_code', $bb)
                                ->update([
                                    'm_stok_saldo' => $get_stok->m_stok_saldo - $qty,
                                    'm_stok_keluar' => $get_stok->m_stok_keluar + $qty,
                                    'm_stok_updated_at' => Carbon::now(),
                                ]);
                            $stok_detail = [
                                'm_stok_detail_id' => JangkrikHelper::getNextIdCron('m_stok_detail', $get_trans_m_w, $get_user_id),
                                'm_stok_detail_tgl' => Carbon::now(),
                                'm_stok_detail_m_produk_code' => $bb,
                                'm_stok_detail_m_produk_nama' => $get_stok->m_stok_produk_nama,
                                'm_stok_detail_satuan_id' => $get_stok->m_stok_satuan_id,
                                'm_stok_detail_satuan' => $get_stok->m_stok_satuan,
                                'm_stok_detail_gudang_code' => $get_gudang_code,
                                'm_stok_detail_keluar' => convertfloat($qty),
                                'm_stok_detail_saldo' => $get_stok->m_stok_saldo - convertfloat($qty),
                                'm_stok_detail_hpp' => $get_stok->m_stok_hpp,
                                'm_stok_detail_catatan' => 'penjualan cr ' . $key->log_transaksi_cr_r_t_id,
                                'm_stok_detail_created_by' => 1,
                            ];
                            DB::table('m_stok_detail')->insert($stok_detail);
                        }
                    }
                }
            }
            $remove_list = DB::table('log_transaksi_cr')
                ->where('log_transaksi_cr_r_t_id', $key->log_transaksi_cr_r_t_id)
                ->delete();
        }
        Log::info("Cron Job Pengurangan Stok Finish at ". Carbon::now()->format('Y-m-d H:i:s'));
        return Command::SUCCESS;
    }
}
