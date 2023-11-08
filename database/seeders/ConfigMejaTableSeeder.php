<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class ConfigMejaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("m_meja")->truncate();

        for ($i=1; $i <= 30 ; $i++) { 
            // $id = DB::select("select nextval('m_meja_id_seq');")[0]->nextval;
            $id = DB::select("SELECT MAX(id) FROM m_meja;")[0]->max+1;

            DB::table('m_meja')->insert([
                "m_meja_id"=> "{$id}",
                "m_meja_nama"=> "{$i}",
                "m_meja_m_meja_jenis_id"=> "6",
                "m_meja_m_w_id"=> "1",
                "m_meja_type"=> "meja",
                "m_meja_created_by"=> 1
            ]);
        }

        for ($i=1; $i <= 4 ; $i++) { 
            // $id = DB::select("select nextval('m_meja_id_seq');")[0]->nextval;
            $id = DB::select("SELECT MAX(id) FROM m_meja;")[0]->max+1;

            DB::table('m_meja')->insert([
                "m_meja_id"=> "{$id}",
                "m_meja_nama"=> "Express-{$i}",
                "m_meja_m_meja_jenis_id"=> "10",
                "m_meja_m_w_id"=> "1",
                "m_meja_type"=> "express",
                "m_meja_created_by"=> 1
            ]);
        }

        for ($i=1; $i <= 10 ; $i++) { 
            // $id = DB::select("select nextval('m_meja_id_seq');")[0]->nextval;
            $id = DB::select("SELECT MAX(id) FROM m_meja;")[0]->max+1;

            DB::table('m_meja')->insert([
                "m_meja_id"=> "{$id}",
                "m_meja_nama"=> "Bks-{$i}",
                "m_meja_m_meja_jenis_id"=> "11",
                "m_meja_m_w_id"=> "1",
                "m_meja_type"=> "bungkus",
                "m_meja_created_by"=> 1
            ]);
        }
        
    }
}