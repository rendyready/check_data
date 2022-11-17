<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MenuJenisNotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jenis_nota')->truncate();
        $jenisnota = ['Nota A','Nota B'];

        foreach ($jenisnota as $key => $value) {
            DB::table('m_jenis_nota')->insert([
                'm_jenis_nota_nama' => $value,
                'm_jenis_nota_created_by'=> 1,
            ]);
        }
    }
}
