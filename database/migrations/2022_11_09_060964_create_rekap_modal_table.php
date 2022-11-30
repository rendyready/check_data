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
            $table->id('rekap_modal_id');
            $table->bigInteger('rekap_modal_sync_id')->nullable();
            $table->bigInteger('rekap_modal_m_w_id');
            $table->integer('rekap_modal_shift')->default(1);
            $table->dateTime('rekap_modal_tanggal')->useCurrent();
            $table->decimal('rekap_modal_nominal', 15);
            $table->boolean('rekap_modal_status')->default(true);
            $table->bigInteger('rekap_modal_created_by');
            $table->bigInteger('rekap_modal_updated_by')->nullable();
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
