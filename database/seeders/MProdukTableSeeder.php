<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class MProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_produk')->truncate();
        DB::table('m_produk')->insert([
            [
                'm_produk_code' =>'FG-11-000-018',
                'm_produk_nama' => 'Sambal Bajak',
                'm_produk_urut' => '001-001',
                'm_produk_cr' => 'Sambal Bajak',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-009',
                'm_produk_nama' => 'Sambal Bawang',
                'm_produk_urut' => '001-002',
                'm_produk_cr' => 'Sambal Bawang',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-060',
                'm_produk_nama' => 'Sambal Bawang Jos',
                'm_produk_urut' => '001-003',
                'm_produk_cr' => 'Sambal Bawang Jos',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-035',
                'm_produk_nama' => 'Sambal Bawang Bakar',
                'm_produk_urut' => '001-004',
                'm_produk_cr' => 'Sambal Bawang Bakar',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-010',
                'm_produk_nama' => 'Sambal Bawang Goreng',
                'm_produk_urut' => '001-005',
                'm_produk_cr' => 'Sambal Bawang Goreng',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-11-000-011',
                'm_produk_nama' => 'Sambal Bawang Tomat',
                'm_produk_urut' =>' 001-006',
                'm_produk_cr' => 'Sambal Bawang Tomat',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-11-000-026',
                'm_produk_nama' => 'Sambal Bawang Brambang Goreng',
                'm_produk_urut' => '001-007',
                'm_produk_cr' => 'Sambal Bawang Brambang Goreng',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-11-000-044',
                'm_produk_nama' => 'Sambal Matah',
                'm_produk_urut' => '001-007',
                'm_produk_cr' => 'Sambal Matah',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-11-000-020',
                'm_produk_nama' => 'Sambal Gobal-Gabul',
                'm_produk_urut' => '001-009',
                'm_produk_cr' => 'Sambal Gobal-Gabul',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-015',
                'm_produk_nama' => 'Sambal Kecap',
                'm_produk_urut' =>'001-010',
                'm_produk_cr' => 'Sambal Kecap',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-012',
                'm_produk_nama' => 'Sambal Bawang Lombok Ijo',
                'm_produk_urut' =>'001-011',
                'm_produk_cr' => 'Sambal Bawang Lombok Ijo',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-027',
                'm_produk_nama' => 'Sambal Mangga Muda',
                'm_produk_urut' =>'001-012',
                'm_produk_cr' => 'Sambal Mangga Muda',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-042',
                'm_produk_nama' => 'Sambal Nanas',
                'm_produk_urut' =>'001-013',
                'm_produk_cr' => 'Sambal Nanas',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-019',
                'm_produk_nama' => 'Sambal Tomat Trasi Matang',
                'm_produk_urut' =>'001-014',
                'm_produk_cr' => 'Sambal Tomat Trasi Matang',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-008',
                'm_produk_nama' => 'Sambal Trasi Lombok Ijo',
                'm_produk_urut' =>'001-015',
                'm_produk_cr' => 'Sambal Trasi Lombok Ijo',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-006',
                'm_produk_nama' => 'Sambal Trasi Matang',
                'm_produk_urut' =>'001-016',
                'm_produk_cr' => 'Sambal Trasi Matang',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-005',
                'm_produk_nama' => 'Sambal Trasi Segar',
                'm_produk_urut' =>'001-017',
                'm_produk_cr' => 'Sambal Trasi Segar',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-11-000-007',
                'm_produk_nama' => 'Sambal Trasi Tomat Segar',
                'm_produk_urut' =>'001-018',
                'm_produk_cr' => 'Sambal Trasi Tomat Segar',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-036',
                'm_produk_nama' => 'Sambal Trasi Brambang Tomat',
                'm_produk_urut' =>'001-019',
                'm_produk_cr' => 'Sambal Trasi Brambang Tomat',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>4,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-11-000-001',
                'm_produk_nama' => 'Sambal Belut',
                'm_produk_urut' =>'001-020',
                'm_produk_cr' => 'Sambal Belut',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>3,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>3,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-12-000-094',
                'm_produk_nama' => 'Ayam Pedas Gobal-Gabul',
                'm_produk_urut' =>'002-001',
                'm_produk_cr' => 'Ayam Pedas Gobal-Gabul',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>5,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-12-000-009',
                'm_produk_nama' => 'Ayam Kampung Dada (Goreng)',
                'm_produk_urut' =>'002-002',
                'm_produk_cr' => 'Ayam Kampung Dada (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-12-000-010',
                'm_produk_nama' => 'Ayam Kampung Dada (Bakar)',
                'm_produk_urut' =>'002-003',
                'm_produk_cr' => 'Ayam Kampung Dada (Bakar)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>7,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-12-000-007',
                'm_produk_nama' => 'Ayam Kampung Paha (Goreng)',
                'm_produk_urut' =>'002-004',
                'm_produk_cr' => 'Ayam Kampung Paha (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-12-000-048',
                'm_produk_nama' => 'Bebek Dada (Goreng)',
                'm_produk_urut' =>'002-013',
                'm_produk_cr' => 'Bebek Dada (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-12-000-046',
                'm_produk_nama' => 'Bebek Paha (Goreng)',
                'm_produk_urut' =>'002-015',
                'm_produk_cr' => 'Bebek Paha (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'FG-12-000-002',
                'm_produk_nama' => 'Belut Sawah Polos',
                'm_produk_urut' =>'002-017',
                'm_produk_cr' => 'Belut Sawah Polos',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-12-000-029',
                'm_produk_nama' => 'Ikan Bandeng (Goreng)',
                'm_produk_urut' =>'002-018',
                'm_produk_cr' => 'Ikan Bandeng (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-12-000-058',
                'm_produk_nama' => 'Ikan Gurame (Goreng)',
                'm_produk_urut' =>'002-022',
                'm_produk_cr' => 'Ikan Gurame (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	FG-12-000-058',
                'm_produk_nama' => 'Ikan Gurame (Goreng)',
                'm_produk_urut' =>'002-022',
                'm_produk_cr' => 'Ikan Gurame (Goreng)',
                'm_produk_status'=> 1,
                'm_produk_tax'=> 1,
                'm_produk_sc'=> 1,
                'm_produk_m_jenis_produk_id'=>4,
                'm_produk_utama_m_satuan_id'=>4,
                'm_produk_m_plot_produksi_id'=>1,
                'm_produk_m_klasifikasi_produk_id'=>4,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'sales',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	RM-17-000-106',
                'm_produk_nama' => 'Ayam Negeri Dada Asin Frozen',
                'm_produk_urut' =>'000-001',
                'm_produk_cr' => 'Ayam Negeri Dada Asin Frozen',
                'm_produk_status'=>1,
                'm_produk_tax'=> 0,
                'm_produk_sc'=> 0,
                'm_produk_m_jenis_produk_id'=>0,
                'm_produk_utama_m_satuan_id'=>3,
                'm_produk_m_plot_produksi_id'=>0,
                'm_produk_m_klasifikasi_produk_id'=>0,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
            [
                'm_produk_code' =>'	RM-17-000-011',
                'm_produk_nama' => 'Bumbu Tabur Bawang',
                'm_produk_urut' =>'000-002',
                'm_produk_cr' => 'Bumbu Tabur Bawang',
                'm_produk_status'=>1,
                'm_produk_tax'=> 0,
                'm_produk_sc'=>0,
                'm_produk_m_jenis_produk_id'=>0,
                'm_produk_utama_m_satuan_id'=>1,
                'm_produk_m_plot_produksi_id'=>0,
                'm_produk_m_klasifikasi_produk_id'=>0,
                'm_produk_jual'=>'ya',
                'm_produk_scp'=>'ya',
                'm_produk_hpp'=>'scp',
                'm_produk_created_by'=>'1',
            ],
        ]);
    }
}