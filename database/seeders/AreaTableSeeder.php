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
        DB::table('m_area')->insert([
            [
                'm_area_nama' =>'Jabodetabek',
                'm_area_code'=>'JBK',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Purwokerto',
                'm_area_code'=>'PWT',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Semarang',
                'm_area_code'=>'SMG',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Perintis',
                'm_area_code'=>'PRS',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Yogyakarta',
                'm_area_code'=>'JOG',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Solo',
                'm_area_code'=>'SOL',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Malang',
                'm_area_code'=>'MLG',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Bali',
                'm_area_code'=>'BLI',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Pusat',
                'm_area_code'=>'PST',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Eksternal & Waralaba',
                'm_area_code'=>'EKT',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_nama' =>'Asia Pasific',
                'm_area_code'=>'AP',
                'm_area_created_by'=>1
            ], 
        ]);
        }
    }

