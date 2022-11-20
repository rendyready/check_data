<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MTransaksiTipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_transaksi_tipe')->truncate();

        DB::table('m_transaksi_tipe')->insert([
            [
                'm_t_t_name' => 'Grab',
                'm_t_t_profit_price' => 0.35,
                'm_t_t_profit_in' => 0.2,
                'm_t_t_profit_out'=> 0.15,
                'm_t_t_group'=>'Ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'Gojek',
                'm_t_t_profit_price' => 0.35,
                'm_t_t_profit_in' => 0.23,
                'm_t_t_profit_out'=> 0.12,
                'm_t_t_group'=>'Ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'Takeaway',
                'm_t_t_profit_price' => 0,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'Reguler',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'Grabmart',
                'm_t_t_profit_price' => 0.94,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'Ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'Dinein',
                'm_t_t_profit_price' => 0,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'Reguler',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'ShopeeFood',
                'm_t_t_profit_price' => 0.25,
                'm_t_t_profit_in' => 0.19,
                'm_t_t_profit_out'=> 0.06,
                'm_t_t_group'=>'Ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'Maxim',
                'm_t_t_profit_price' => 0,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'Ojol',
                'm_t_t_created_by'=> 1
            ],
           
        ]);
    }
}