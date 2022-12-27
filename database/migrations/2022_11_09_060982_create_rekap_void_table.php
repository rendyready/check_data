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
        Schema::create('rekap_void', function (Blueprint $table) {
            $table->id('r_v_id');
            $table->bigInteger('r_v_sync_id')->nullable();
            $table->bigInteger('r_v_r_t_id');
            $table->bigInteger('r_v_m_produk_id');
            // $table->string('r_v_m_produk_nama');
            $table->decimal('r_v_price', 8,2);
            $table->integer('r_v_qty');
            $table->decimal('r_v_nominal', 15,2);
            $table->decimal('r_v_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_v_nominal_sc', 15,2)->default(0);
            $table->decimal('r_v_nominal_sharing_profit', 15,2)->default(0);
            $table->string('r_v_keterangan');
            $table->char('r_v_status_sync', 10)->default('0');
            $table->bigInteger('r_v_created_by');
            $table->bigInteger('r_v_updated_by')->nullable();
            $table->bigInteger('r_v_deleted_by')->nullable();
            $table->timestampTz('r_v_created_at')->useCurrent();
            $table->timestampTz('r_v_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_v_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_void');
    }
};
