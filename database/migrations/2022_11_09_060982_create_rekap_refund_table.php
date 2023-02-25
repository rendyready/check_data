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
        Schema::create('rekap_refund', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_r_id')->unique();
            // $table->bigInteger('r_r_sync_id')->nullable();
            $table->string('r_r_rekap_modal_id');
            $table->string('r_r_r_t_id');
            $table->string('r_r_nota_code');
            $table->string('r_r_bigboss');
            $table->date('r_r_tanggal');
            $table->time('r_r_jam');
            $table->unsignedBigInteger('r_r_m_area_id');
            $table->string('r_r_m_area_nama')->nullable();
            $table->unsignedBigInteger('r_r_m_w_id');
            $table->string('r_r_m_w_nama')->nullable();
            $table->decimal('r_r_nominal_refund', 15,2)->default(0);
            $table->decimal('r_r_nominal_refund_pajak', 15,2)->default(0);
            $table->decimal('r_r_nominal_refund_sc', 15,2)->default(0);
            $table->decimal('r_r_nominal_pembulatan_refund', 15,2)->default(0);
            $table->decimal('r_r_nominal_free_kembalian_refund', 15,2)->default(0);
            $table->decimal('r_r_nominal_refund_total', 15,2)->default(0);
            $table->decimal('r_r_tax_percent',5,2)->default(0);
            $table->decimal('r_r_sc_percent',5,2)->default(0);
            $table->string('r_r_keterangan')->nullable();
            $table->char('r_r_status_sync', 10)->default('0');
            $table->unsignedBigInteger('r_r_approved_by')->nullable();
            $table->bigInteger('r_r_created_by');
            $table->bigInteger('r_r_updated_by')->nullable();
            $table->bigInteger('r_r_deleted_by')->nullable();
            $table->timestampTz('r_r_created_at')->useCurrent();
            $table->timestampTz('r_r_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_r_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_refund');
    }
};
