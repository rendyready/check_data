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
        Schema::create('rekap_hapus_transaksi', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_h_t_id')->unique();
            // $table->bigInteger('r_h_t_sync_id')->nullable();
            $table->string('r_h_t_rekap_modal_id');
            // $table->string('r_h_t_tmp_transaction_id');
            // $table->bigInteger('r_h_t_m_jenis_nota_id');
            // $table->string('r_h_t_m_jenis_nota_nama');
            $table->string('r_h_t_nota_code');
            // $table->smallInteger('r_h_t_shift');
            $table->date('r_h_t_tanggal'); //
            $table->time('r_h_t_jam'); //jam nota
            // $table->bigInteger('r_h_t_m_meja_id');
            // $table->string('r_h_t_m_meja_nama');
            $table->string('r_h_t_bigboss');
            $table->string('r_h_t_m_area_id');
            $table->string('r_h_t_m_area_nama')->nullable();
            $table->string('r_h_t_m_w_id');
            $table->string('r_h_t_m_w_nama')->nullable();
            $table->decimal('r_h_t_nominal', 15,2)->default(0);
            $table->decimal('r_h_t_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_h_t_nominal_sc', 15,2)->default(0);
            $table->decimal('r_h_t_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_h_t_nominal_sharing_profit_out', 15,2)->default(0);
            $table->string('r_h_t_m_t_t_id');
            // $table->string('r_h_t_m_t_t_name');
            // $table->decimal('r_h_t_m_t_t_profit_price', 3)->default(0);
            // $table->decimal('r_h_t_m_t_t_profit_in', 3)->default(0);
            // $table->decimal('r_h_t_m_t_t_profit_out', 3)->default(0);
            $table->char('r_h_t_status_sync', 10)->default('0');
            // $table->bigInteger('r_h_t_kasir_id');
            // $table->string('r_h_t_kasir_nama');
            $table->bigInteger('r_h_t_approved_by')->nullable();
            $table->bigInteger('r_h_t_created_by');
            $table->bigInteger('r_h_t_updated_by')->nullable();
            $table->bigInteger('r_h_t_deleted_by')->nullable();
            $table->timestampTz('r_h_t_created_at')->useCurrent();
            $table->timestampTz('r_h_t_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_h_t_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_hapus_transaksi');
    }
};
