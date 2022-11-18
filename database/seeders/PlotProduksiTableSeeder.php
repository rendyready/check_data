<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class PlotProduksiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_plot_produksi')->truncate();
        $plotprod = ['Goreng','Tepung','Sambal Non Bawang','Sambal Masak + Telur','Ca/Tumis','Bakaran','Buah','Minum','Sayur','Nasi'];

        foreach ($plotprod as $key => $value) {
            DB::table('m_plot_produksi')->insert([
                'm_plot_produksi_nama' => $value,
                'm_plot_produksi_created_by'=> 1,
            ]);
        }
    }
}
