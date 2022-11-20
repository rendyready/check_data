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
        Schema::create('m_resep', function (Blueprint $table) {
            $table->id('m_resep_id');
            $table->bigInteger('m_resep_m_produk_id');
            $table->bigInteger('m_resep_bb_id');
            $table->bigInteger('m_resep_m_satuan_id');
            $table->char('m_resep_status'); //aktif, non aktif
            $table->bigInteger('m_resep_created_by');
            $table->bigInteger('m_resep_updated_by')->nullable();
            $table->timestampTz('m_resep_created_at')->useCurrent();
            $table->timestampTz('m_resep_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_resep_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_resep');
    }
};
