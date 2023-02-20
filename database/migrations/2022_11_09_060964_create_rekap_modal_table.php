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
        Schema::create('rekap_modal', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_modal_id')->unique();
            // $table->bigInteger('rekap_modal_sync_id')->nullable();
            $table->string('rekap_modal_m_w_id');
            $table->string('rekap_modal_m_w_nama')->nullable();
            $table->string('rekap_modal_m_area_id')->nullable();
            $table->string('rekap_modal_m_area_nama')->nullable();
            $table->integer('rekap_modal_sesi')->default(1);
            $table->dateTime('rekap_modal_tanggal')->useCurrent();
            $table->decimal('rekap_modal_nominal', 15,2);
            $table->decimal('rekap_modal_sales', 15,2)->default(0);
            $table->decimal('rekap_modal_cash', 15,2)->default(0);
            $table->decimal('rekap_modal_cash_real', 15,2)->default(0);
            $table->char('rekap_modal_status',5)->default('open');
            $table->char('rekap_modal_status_sync', 10)->default('0');
            $table->bigInteger('rekap_modal_created_by');
            $table->bigInteger('rekap_modal_updated_by')->nullable();
            $table->bigInteger('rekap_modal_deleted_by')->nullable();
            $table->timestampTz('rekap_modal_created_at')->useCurrent();
            $table->timestampTz('rekap_modal_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_modal_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_modal');
    }
};
