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
        Schema::create('rekap_modal_detail', function (Blueprint $table) {
            $table->id('rekap_modal_detail_id');
            $table->bigInteger('rekap_modal_detail_sync_id')->nullable();
            $table->bigInteger('rekap_modal_detail_qty')->nullable()->default(0);
            $table->bigInteger('rekap_modal_detail_m_modal_tipe_id');
            $table->bigInteger('rekap_modal_detail_rekap_modal_id');
            $table->bigInteger('rekap_modal_detail_created_by');
            $table->bigInteger('rekap_modal_detail_deleted_by');
            $table->bigInteger('rekap_modal_detail_updated_by')->nullable();
            $table->timestampTz('rekap_modal_detail_created_at')->useCurrent();
            $table->timestampTz('rekap_modal_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_modal_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_modal_detail');
    }
};
