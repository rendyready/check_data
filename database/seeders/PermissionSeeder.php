<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert([
            [
                'name' => 'module dashboard.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'module cr55.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'module akuntansi.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'module inventori.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'module hrd.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'module user.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'setting cr.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'daftar produk.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'daftar produk.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'subjenis produk.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'subjenis produk.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'setting harga.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'setting harga.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'setting meja.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'seting footer.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'setting footer.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'master cr.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'area.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'area.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'tipe waroeng.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'tipe waroeng.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'pajak.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'pajak.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'service charge.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'service charge.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'waroeng.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'waroeng.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'jenis produk.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'jenis produk.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'klasifikasi produk.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'klasifiksai produk.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'm_subjenis produk.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'm_subjenis produk.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'modal tipe.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'modal tipe.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'jenis meja.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'jenis meja.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'transaksi tipe.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'transaksi tipe.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'satuan.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'satuan.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'plot produksi.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'plot produksi.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'level jabatan.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'level jabatan.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan cr.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan cr.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'detail nota.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap nota.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap nota harian.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap menu summary.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap menu tarikan.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap refund.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap lostbill.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap garansi.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan kas harian.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap summary penjualan.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap penjualan kat menu.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap penjualan non menu.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap aktifitas kasir.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap buka laci.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap hapus menu.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rekap nota kasir.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'master inventori.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'resep.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'resep.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'data bb.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'data bb.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'data gudang.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'data gudang.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'stok awal.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'stok awal.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'supplier.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'supplier.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rph.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'rph.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kebutuhan belanja.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'purchase order.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'pembelian.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'cht pembelian.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'keluar gudang.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'terima gudang.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'pecah gabung barang.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'penjualan bb internal.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'barang rusak.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'stok opname.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan inventori.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kartu stok.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan rph.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan pembelian.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan cht.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'keluar masuk gudang.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'laporan pengiriman.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user.view',
                'guard_name' => 'web',
            ],
            [
                'name' => 'user.edit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'hak akses.view',
                'guard_name' => 'web',
            ]
        ]);
    }
}
