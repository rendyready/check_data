<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TriggerMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table[1] = 'users';
        $table[2] = 'm_area';
        $table[3] = 'm_pajak';
        $table[4] = 'm_sc';
        $table[5] = 'm_w_jenis';
        $table[6] = 'm_w';
        $table[7] = 'm_footer';
        $table[8] = 'm_jenis_nota';
        $table[9] = 'm_menu_harga';
        $table[10] = 'm_jenis_produk';
        $table[11] = 'm_klasifikasi_produk';
        $table[12] = 'm_plot_produksi';
        $table[13] = 'm_satuan';
        $table[14] = 'm_produk';
        $table[15] = 'm_sub_jenis_produk';
        $table[16] = 'config_sub_jenis_produk';
        $table[17] = 'm_kasir_akses';
        $table[18] = 'm_meja_jenis';
        $table[19] = 'm_meja';
        $table[20] = 'm_modal_tipe';
        $table[21] = 'm_payment_method';
        $table[22] = 'm_supplier';
        $table[23] = 'm_satuan';
        // $table[24] = 'm_jabatan';
        // $table[25] = 'history_pendidikan';
        // $table[26] = 'history_jabatan';
        // $table[27] = 'm_group_produk';
        // $table[28] = 'm_level_jabatan';
        $table[28] = 'm_stok';
        $table[29] = 'm_rekening';
        $table[30] = 'm_link_akuntansi';
        $table[31] = 'm_akun_bank';

        foreach ($table as $key => $valTable) {

            DB::unprepared('
            CREATE OR REPLACE FUNCTION '.$valTable.'_insert_trigger_fnc()
            RETURNS trigger AS
            $$
            BEGIN
                UPDATE '.$valTable.' SET '.$valTable.'_id = NEW."id" WHERE "id" = NEW."id";
                RETURN NEW;
            END;
            $$
            LANGUAGE plpgsql;
            ');

            DB::unprepared('
            CREATE OR REPLACE TRIGGER '.$valTable.'_insert_trigger
            AFTER INSERT
            ON "'.$valTable.'"
            FOR EACH ROW
            EXECUTE PROCEDURE '.$valTable.'_insert_trigger_fnc();
            ');
        }

            DB::unprepared('
            CREATE OR REPLACE FUNCTION m_transaksi_tipe_insert_trigger_fnc()
            RETURNS trigger AS
            $$
            BEGIN
                UPDATE m_transaksi_tipe SET m_t_t_id = NEW."id" WHERE "id" = NEW."id";
                RETURN NEW;
            END;
            $$
            LANGUAGE plpgsql;
            ');

            DB::unprepared('
            CREATE OR REPLACE TRIGGER m_transaksi_tipe_insert_trigger
            AFTER INSERT
            ON "m_transaksi_tipe"
            FOR EACH ROW
            EXECUTE PROCEDURE m_transaksi_tipe_insert_trigger_fnc();
            ');
    }
}
