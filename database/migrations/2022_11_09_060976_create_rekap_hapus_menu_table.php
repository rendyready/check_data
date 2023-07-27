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
        Schema::create('rekap_hapus_menu', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_h_m_id')->unique();
            // $table->bigInteger('r_h_m_sync_id')->nullable();
            $table->string('r_h_m_rekap_modal_id');
            // $table->string('r_h_m_tmp_transaction_id');
            $table->date('r_h_m_tanggal');
            $table->time('r_h_m_jam');
            $table->string('r_h_m_nota_code');
            $table->string('r_h_m_bigboss');
            $table->unsignedBigInteger('r_h_m_m_produk_id');
            $table->string('r_h_m_m_produk_code')->nullable();
            $table->string('r_h_m_m_produk_nama')->nullable();
            $table->integer('r_h_m_qty');
            $table->decimal('r_h_m_reguler_price', 8,2)->default(0);
            $table->decimal('r_h_m_price', 8,2);
            $table->decimal('r_h_m_nominal', 15,2);
            $table->decimal('r_h_m_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_h_m_nominal_sc', 15,2)->default(0);
            $table->decimal('r_h_m_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_h_m_nominal_sharing_profit_out', 15,2)->default(0);
            $table->string('r_h_m_keterangan');
            $table->unsignedBigInteger('r_h_m_m_w_id');
            $table->string('r_h_m_m_w_code')->nullable();
            $table->string('r_h_m_m_w_nama')->nullable();
            $table->unsignedBigInteger('r_h_m_m_area_id');
            $table->string('r_h_m_m_area_code')->nullable();
            $table->string('r_h_m_m_area_nama')->nullable();
            $table->string('r_h_m_status_sync', 20)->default('send');
            $table->unsignedBigInteger('r_h_m_approved_by')->nullable();
            $table->bigInteger('r_h_m_created_by');
            $table->bigInteger('r_h_m_updated_by')->nullable();
            $table->bigInteger('r_h_m_deleted_by')->nullable();
            $table->timestampTz('r_h_m_created_at')->useCurrent();
            $table->timestampTz('r_h_m_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_h_m_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_hapus_menu');
    }
};