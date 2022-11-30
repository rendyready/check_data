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
        Schema::create('m_jabatan', function (Blueprint $table) {
            $table->id('m_jabatan_id');
            $table->bigInteger('m_jabatan_m_level_jabatan_id');
            $table->string('m_jabatan_nama');
            $table->bigInteger('m_jabatan_parent_id')->nullable()->default(NULL);
            $table->bigInteger('m_jabatan_created_by');
            $table->bigInteger('m_jabatan_updated_by')->nullable();
            $table->bigInteger('m_jabatan_deleted_by')->nullable();
            $table->timestampTz('m_jabatan_created_at')->useCurrent();
            $table->timestampTz('m_jabatan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_jabatan_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_jabatan');
    }
};
