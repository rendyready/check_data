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
                'm_area_id' =>'1',
                'm_area_nama' =>'jabodetabek',
                'm_area_code'=>'601',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'2',
                'm_area_nama' =>'purwokerto',
                'm_area_code'=>'602',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'3',
                'm_area_nama' =>'semarang',
                'm_area_code'=>'603',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'4',
                'm_area_nama' =>'perintis',
                'm_area_code'=>'604',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'5',
                'm_area_nama' =>'yogyakarta',
                'm_area_code'=>'605',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'6',
                'm_area_nama' =>'solo',
                'm_area_code'=>'606',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'7',
                'm_area_nama' =>'malang',
                'm_area_code'=>'607',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'8',
                'm_area_nama' =>'bali',
                'm_area_code'=>'608',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'9',
                'm_area_nama' =>'pusat',
                'm_area_code'=>'609',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'10',
                'm_area_nama' =>'eksternal & waralaba',
                'm_area_code'=>'610',
                'm_area_created_by'=>1
            ], 
            [
                'm_area_id' =>'11',
                'm_area_nama' =>'asia pasific',
                'm_area_code'=>'611',
                'm_area_created_by'=>1
            ], 
        ]);
        }
    }

