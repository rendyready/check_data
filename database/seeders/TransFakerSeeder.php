<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class TransFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 100000000; $i++){
          DB::table('tb_trans_test')->insert([
              'tb_trans_test_rekap_beli_code' => $faker->isbn10,
              'tb_trans_test_m_produk_id' => $faker->numberBetween(1,20),
              'tb_trans_test_m_produk_code' => $faker->isbn10,
              'tb_trans_test_m_produk_nama' => $faker->name,
              'tb_trans_test_catatan' => $faker->sentence($nbWords = 6, $variableNbWords = true),
              'tb_trans_test_qty'=> $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 4),
              'tb_trans_test_harga' => $faker->randomNumber($nbDigits = 6, $strict = false),
              'tb_trans_test_disc' => $faker->numberBetween(1,100),
              'tb_trans_test_discrp' => $faker->randomNumber($nbDigits = 5, $strict = false),
              'tb_trans_test_subtot' =>  $faker->randomNumber($nbDigits = 7, $strict = false),
              'tb_trans_test_terima' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = NULL),
              'tb_trans_test_satuan_terima' => $faker->name,
              'tb_trans_test_waroeng_id' => $faker->numberBetween(1,100),
              'tb_trans_test_waroeng'=> $faker->name,
              'tb_trans_test_created_by' => $faker->numberBetween(1,100),
          ]);

      }
            // $master_produk = DB::table('m_w')->get();
            // foreach ($master_produk as $key) {
            //     DB::table('tb_trans_test')
            //     ->where('tb_trans_test_waroeng_id',$key->m_w_id)
            //     ->update(['tb_trans_test_waroeng_nama' => $key->m_w_nama]);
            // }
    }
}
