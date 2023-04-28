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
        Schema::create('m_std_bb_resep', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_std_bb_resep_id')->unique();
            $table->string('m_std_bb_resep_m_produk_code');
            $table->decimal('m_std_bb_resep_qty',14,2);
            $table->string('m_std_bb_resep_porsi');
            $table->string("m_std_bb_resep_status_sync", 20)->default('send');
            $table->bigInteger('m_std_bb_resep_created_by');
            $table->bigInteger('m_std_bb_resep_updated_by')->nullable();
            $table->bigInteger('m_std_bb_resep_deleted_by')->nullable();
            $table->timestampTz('m_std_bb_resep_created_at')->useCurrent();
            $table->timestampTz('m_std_bb_resep_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_std_bb_resep_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_std_bb_resep');
    }
};
