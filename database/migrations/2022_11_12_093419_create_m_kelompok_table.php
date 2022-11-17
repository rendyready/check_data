<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_kelompok', function (Blueprint $table) {
            $table->id('m_kelompok_id');
            $table->string('m_kelompok_nama');
            $table->bigInteger('m_kelompok_created_by');
            $table->bigInteger('m_kelompok_updated_by')->nullable();
            $table->timestampTz('m_kelompok_created_at')->useCurrent();
            $table->timestampTz('m_kelompok_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_kelompok_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kelompok');
    }
}
