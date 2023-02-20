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
        Schema::create('rekap_garansi', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_garansi_id')->unique();
            // $table->bigInteger('rekap_garansi_sync_id')->nullable();
            $table->string('rekap_garansi_r_t_id');
            $table->unsignedBigInteger('rekap_garansi_m_produk_id');
            $table->string('rekap_garansi_m_produk_nama')->nullable();
            $table->decimal('rekap_garansi_price', 15);
            $table->integer('rekap_garansi_qty');
            $table->decimal('rekap_garansi_nominal', 15);
            $table->string('rekap_garansi_keterangan');
            $table->string('rekap_garansi_action');
            $table->char('rekap_garansi_status_sync', 10)->default('0');
            $table->bigInteger('rekap_garansi_created_by');
            $table->bigInteger('rekap_garansi_updated_by')->nullable();
            $table->bigInteger('rekap_garansi_deleted_by')->nullable();
            $table->timestampTz('rekap_garansi_created_at')->useCurrent();
            $table->timestampTz('rekap_garansi_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_garansi_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_garansi');
    }
};
