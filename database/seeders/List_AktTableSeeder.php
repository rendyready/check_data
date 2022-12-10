<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class List_AktTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('list_akt')->truncate();
        DB::table('list_akt')->insert([
            [
                'list_akt_nama' =>'Pembelian',
                'list_akt_created_by'=>1,
            ], 
            [
                'list_akt_nama' =>'Hutang Dagang',
                'list_akt_created_by'=>1,
            ], 
            [
                'list_akt_nama' =>'PPN Pembelian',
                'list_akt_created_by'=>1,
            ],  
            [
                'list_akt_nama' =>'Ongkir Pembelian',
                'list_akt_created_by'=>1,
            ],  
            [
                'list_akt_nama' =>'Penjualan ',
                'list_akt_created_by'=>1,
            ],  
            [
                'list_akt_nama' =>'PPN Penjualan',
                'list_akt_created_by'=>1,
            ], 
            [
                'list_akt_nama' =>'Ongkir Penjualan',
                'list_akt_created_by'=>1,
            ],  
            [
                'list_akt_nama' =>'Barang Rusak Menu',
                'list_akt_created_by'=>1,
            ], 
            [
                'list_akt_nama' =>'Barang Rusak Pembantu',
                'list_akt_created_by'=>1,
            ],  
            [
                'list_akt_nama' =>'HPP Penjualan',
                'list_akt_created_by'=>1,
            ], 
            [
                'list_akt_nama' =>'HPP Pembelian',
                'list_akt_created_by'=>1,
            ], 
        ]);
        }
    }

