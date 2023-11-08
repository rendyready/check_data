<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateRekapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        #Rekap
        DB::statement("TRUNCATE TABLE rekap_buka_laci RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_garansi RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_hapus_menu RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_hapus_transaksi RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_hapus_transaksi_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_lost_bill RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_lost_bill_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_member RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_modal RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_modal_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_mutasi_modal RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_uang_tips RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_transaksi RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_transaksi_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_payment_transaksi RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_refund RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_refund_detail RESTART IDENTITY;");

        DB::statement("TRUNCATE TABLE rekap_beli RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_beli_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_inv_penjualan RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_inv_penjualan_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_pcb RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_po RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_po_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_rusak RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_rusak_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_so RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_so_detail RESTART IDENTITY;");
        DB::statement("TRUNCATE TABLE rekap_tf_gudang RESTART IDENTITY;");
    }
}
