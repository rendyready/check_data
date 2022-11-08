<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_area')->truncate();
        $area = ['Area Jabotabek', 'Area Purwokerto', 'Area Semarang','Area Perintis','Area Yogyakarta','Area Solo','Area Malang','Area Bali','Area Eksternal dan Waralaba','Area Asia Pasific','Pusat'];

        foreach ($area as $key => $value) {
            DB::table('m_area')->insert([
                'm_area_nama' => $value,
                'm_area_created_by'=> 1,
            ]);
        }
    }
}
