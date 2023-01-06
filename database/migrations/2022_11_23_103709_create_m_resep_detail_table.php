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
        Schema::create('m_resep_detail', function (Blueprint $table) {
            $table->id('m_resep_detail_id');
            $table->bigInteger('m_resep_detail_m_resep_id');
            $table->bigInteger('m_resep_detail_bb_id'); //id from m_produk
            $table->decimal('m_resep_detail_bb_qty',8,2);
            $table->bigInteger('m_resep_detail_m_satuan_id');
            $table->string('m_resep_detail_ket')->nullable();
            $table->bigInteger('m_resep_detail_created_by');
            $table->bigInteger('m_resep_detail_updated_by')->nullable();
            $table->bigInteger('m_resep_detail_deleted_by')->nullable();
            $table->timestampTz('m_resep_detail_created_at')->useCurrent();
            $table->timestampTz('m_resep_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_resep_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_resep_detail');
    }
};
