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
                'm_t_t_name' => 'dine in',
                'm_t_t_profit_price' => 0,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'reguler',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'take away',
                'm_t_t_profit_price' => 0,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'reguler',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'grab',
                'm_t_t_profit_price' => 0.35,
                'm_t_t_profit_in' => 0.2,
                'm_t_t_profit_out'=> 0.15,
                'm_t_t_group'=>'ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'gojek',
                'm_t_t_profit_price' => 0.35,
                'm_t_t_profit_in' => 0.23,
                'm_t_t_profit_out'=> 0.12,
                'm_t_t_group'=>'ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'grabmart',
                'm_t_t_profit_price' => 0.35,
                'm_t_t_profit_in' => 0.23,
                'm_t_t_profit_out'=> 0.12,
                'm_t_t_group'=>'ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'shopeefood',
                'm_t_t_profit_price' => 0.25,
                'm_t_t_profit_in' => 0.19,
                'm_t_t_profit_out'=> 0.06,
                'm_t_t_group'=>'ojol',
                'm_t_t_created_by'=> 1
            ],
            [
                'm_t_t_name' => 'maxim',
                'm_t_t_profit_price' => 0,
                'm_t_t_profit_in' => 0,
                'm_t_t_profit_out'=> 0,
                'm_t_t_group'=>'ojol',
                'm_t_t_created_by'=> 1
            ],
           
        ]);
    }
}