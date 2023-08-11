<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_parent')->insert([
            'config_parent_name' => 'rekap_transaksi',
            'config_parent_status' => 'on',
            'config_parent_pkey' => 'r_t_id',
            'config_parent_child_name' => 'rekap_transaksi_detail',
            'config_parent_child_pkey' => 'r_t_detail_id',
            'config_parent_child_fkey' => 'r_t_detail_r_t_id',
        ]);
        DB::table('config_parent')->insert([
            'config_parent_name' => 'rekap_transaksi',
            'config_parent_status' => 'on',
            'config_parent_pkey' => 'r_t_id',
            'config_parent_child_name' => 'rekap_payment_transaksi',
            'config_parent_child_pkey' => 'r_p_t_id',
            'config_parent_child_fkey' => 'r_p_t_r_t_id',
        ]);
        DB::table('config_parent')->insert([
            'config_parent_name' => 'm_jenis_nota',
            'config_parent_status' => 'on',
            'config_parent_pkey' => 'm_jenis_nota_id',
            'config_parent_child_name' => 'm_menu_harga',
            'config_parent_child_pkey' => 'm_menu_harga_id',
            'config_parent_child_fkey' => 'm_menu_harga_m_jenis_nota_id',
        ]);
    }
}
