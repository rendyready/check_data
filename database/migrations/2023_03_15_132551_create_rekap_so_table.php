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
        Schema::create('rekap_so', function (Blueprint $table) {
            $table->id('id');
            $table->string('rekap_so_code');
            $table->string('rekap_so_tgl');
            $table->string('rekap_so_detail_m_gudang_code');
            $table->string('rekap_so_m_w_code');
            $table->string('rekap_so_m_w_nama');
            $table->bigInteger('rekap_so_created_by');
            $table->bigInteger('rekap_so_updated_by')->nullable();
            $table->bigInteger('rekap_so_deleted_by')->nullable();
            $table->timestampTz('rekap_so_created_at')->useCurrent();
            $table->timestampTz('rekap_so_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('rekap_so_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_so');
    }
};
