<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('m_supplier');
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_supplier_id')->unique();
            $table->string('m_supplier_code');
            $table->string('m_supplier_nama', 255);
            $table->string('m_supplier_jth_tempo');
            $table->string('m_supplier_alamat', 255);
            $table->string('m_supplier_kota', 100);
            $table->string('m_supplier_telp', 25);
            $table->string('m_supplier_ket', 255);
            $table->string('m_supplier_rek');
            $table->string('m_supplier_rek_nama');
            $table->string('m_supplier_bank_nama');
            $table->decimal('m_supplier_saldo_awal', 8, 2);
            $table->string('m_supplier_status_sync')->default('send');
            $table->bigInteger('m_supplier_created_by');
            $table->bigInteger('m_supplier_updated_by')->nullable();
            $table->bigInteger('m_supplier_deleted_by')->nullable();
            $table->timestampTz('m_supplier_created_at')->useCurrent();
            $table->timestampTz('m_supplier_updated_at')->useCurrentOnUpdate()->nullable()->default(null);
            $table->timestampTz('m_supplier_deleted_at')->nullable()->default(null);
        });
        DB::table('m_supplier')->insert([
            'm_supplier_id' => 1,
            'm_supplier_code' => '500001',
            'm_supplier_nama' => 'Umum',
            'm_supplier_jth_tempo' => 1,
            'm_supplier_alamat' => 'Umum',
            'm_supplier_kota' => 'Umum',
            'm_supplier_telp' => 'Umum',
            'm_supplier_ket' => 'Umum',
            'm_supplier_rek' => 1,
            'm_supplier_rek_nama' => 'Bank Mandiri',
            'm_supplier_bank_nama' => 'Bank Mandiri',
            'm_supplier_saldo_awal' => 0,
            'm_supplier_created_by' => 1,
        ]);
        Schema::dropIfExists('rekap_inv_penjualan');
        Schema::create('rekap_inv_penjualan', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_inv_penjualan_code')->unique(); //id user+ urutan
            $table->date('rekap_inv_penjualan_tgl');
            $table->string('rekap_inv_penjualan_jth_tmp');
            $table->bigInteger('rekap_inv_penjualan_supplier_id');
            $table->string('rekap_inv_penjualan_supplier_nama');
            $table->string('rekap_inv_penjualan_supplier_telp')->nullable();
            $table->string('rekap_inv_penjualan_supplier_alamat')->nullable();
            $table->bigInteger('rekap_inv_penjualan_m_w_id');
            $table->decimal('rekap_inv_penjualan_disc',8,2)->nullable();
            $table->decimal('rekap_inv_penjualan_disc_rp',15,2)->nullable();
            $table->decimal('rekap_inv_penjualan_ppn',8,2)->nullable();
            $table->decimal('rekap_inv_penjualan_ppn_rp',15,2)->nullable();
            $table->decimal('rekap_inv_penjualan_ongkir',18,2)->nullable();
            $table->decimal('rekap_inv_penjualan_tot_nom',18,2);
            $table->decimal('rekap_inv_penjualan_terbayar',18,2);
            $table->decimal('rekap_inv_penjualan_tersisa',18,2);
            $table->string('rekap_inv_penjualan_status_sync')->default('send');
            $table->bigInteger('rekap_inv_penjualan_created_by');
            $table->bigInteger('rekap_inv_penjualan_updated_by')->nullable();
            $table->bigInteger('rekap_inv_penjualan_deleted_by')->nullable();
            $table->timestampTz('rekap_inv_penjualan_created_at')->useCurrent();
            $table->timestampTz('rekap_inv_penjualan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_inv_penjualan_deleted_at')->nullable()->default(NULL);
        });
        Schema::dropIfExists('rekap_beli');
        Schema::create('rekap_beli', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_beli_code')->unique(); //id user+ urutan
            $table->string('rekap_beli_code_nota')->nullable(); //code nota dari supplier jika ada
            $table->date('rekap_beli_tgl');
            $table->string('rekap_beli_jth_tmp');
            $table->string('rekap_beli_supplier_code');
            $table->string('rekap_beli_gudang_code');
            $table->string('rekap_beli_supplier_nama');
            $table->string('rekap_beli_supplier_telp')->nullable();
            $table->string('rekap_beli_supplier_alamat')->nullable();
            $table->bigInteger('rekap_beli_m_w_id');
            $table->string('rekap_beli_waroeng');
            $table->decimal('rekap_beli_disc',8,2)->nullable();
            $table->decimal('rekap_beli_disc_rp')->nullable();
            $table->decimal('rekap_beli_ppn',8,2)->nullable();
            $table->decimal('rekap_beli_ppn_rp',12,2)->nullable();
            $table->decimal('rekap_beli_ongkir',12,2)->nullable();
            $table->decimal('rekap_beli_terbayar',16,2);
            $table->decimal('rekap_beli_tersisa',16,2);
            $table->decimal('rekap_beli_sub_tot',16,2);
            $table->decimal('rekap_beli_tot_nom',16,2);
            $table->string('rekap_beli_ket')->nullable();
            $table->string('rekap_beli_status_sync')->default('send');
            $table->bigInteger('rekap_beli_created_by');
            $table->bigInteger('rekap_beli_updated_by')->nullable();
            $table->bigInteger('rekap_beli_deleted_by')->nullable();
            $table->timestampTz('rekap_beli_created_at')->useCurrent();
            $table->timestampTz('rekap_beli_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_beli_deleted_at')->nullable()->default(NULL);
        });

        Schema::create('rekap_beli_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_beli_detail_rekap_beli_code')->unique();
            $table->string('rekap_beli_detail_m_produk_code');
            $table->string('rekap_beli_detail_m_produk_nama');
            $table->string('rekap_beli_detail_catatan');
            $table->decimal('rekap_beli_detail_qty',5,2);
            $table->decimal('rekap_beli_detail_harga',10,2);
            $table->decimal('rekap_beli_detail_disc',8,2)->nullable();
            $table->decimal('rekap_beli_detail_discrp')->nullable();
            $table->decimal('rekap_beli_detail_subtot',9,2);
            $table->bigInteger('rekap_beli_detail_m_w_id');
            $table->string('rekap_beli_detail_terima_qty')->nullable();
            $table->bigInteger('rekap_beli_detail_satuan_id')->nullable();
            $table->string('rekap_beli_detail_satuan_terima')->nullable();
            $table->string('rekap_beli_detail_status_sync')->default('send');
            $table->bigInteger('rekap_beli_detail_created_by');
            $table->bigInteger('rekap_beli_detail_updated_by')->nullable();
            $table->bigInteger('rekap_beli_detail_deleted_by')->nullable();
            $table->timestampTz('rekap_beli_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_beli_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_beli_detail_deleted_at')->nullable()->default(NULL);
        });

        $table[1] = 'rekap_beli_detail';
        $table[2] = 'm_area';
        $table[3] = 'm_pajak';
        $table[4] = 'm_sc';
        $table[5] = 'm_w_jenis';
        $table[6] = 'm_w';
        $table[7] = 'm_footer';
        $table[8] = 'm_jenis_nota';
        $table[9] = 'm_menu_harga';
        $table[10] = 'm_jenis_produk';
        foreach ($table as $key => $valTable) {
            Schema::table($valTable, function (Blueprint $table) use($valTable) {
                $table->string($valTable."_status_sync", 20)->default('send');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sipedas', function (Blueprint $table) {
            //
        });
    }
};
