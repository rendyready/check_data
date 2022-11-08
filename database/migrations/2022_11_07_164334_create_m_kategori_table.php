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
        Schema::create('m_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('m_kategori_nama');
            $table->bigInteger('m_kategori_m_menu_jenis_id');
            $table->bigInteger('m_kategori_created_by');
            $table->timestampTz('m_kategori_created_at')->useCurrent();
            $table->bigInteger('m_kategori_updated_by')->nullable();
            $table->timestampTz('m_kategori_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_kategori_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kategori');
    }
};
