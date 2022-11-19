<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MWTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_w')->truncate();
        DB::table('m_w')->insert([
            [
                'm_w_nama' =>'WSS Wonosobo',
                'm_w_m_area_id'=>2,
                'm_w_m_w_jenis_id'=>2,
                'm_w_status'=>1,
                'm_w_alamat'=>'Jln Raya Parakan - Wonosobo No.23 Karangluhur, Kenteng, Bojasari,Kec. Kertek, Kabupaten Wonosobo, Jawa Tengah 56371',
                'm_w_m_jenis_nota_id'=>96,
                'm_w_m_pajak_id'=>2,
                'm_w_m_modal_tipe_id'=>6,7,8,9,10,11,12,13,14,15,
                'm_w_m_sc_id'=>1,2,3,
                'm_w_decimal'=>0,
                'm_w_pembulatan'=>'Tidak',
                'm_w_currency'=>'Rp',
                'm_w_grab'=>0,
                'm_w_gojek'=>0,
                'm_menu_profit'=>1,
                'm_w_created_by'=>1,
            ],
        ]);
    }
}