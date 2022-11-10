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
        Schema::create('m_sub_menu_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('m_sub_menu_jenis_nama');
            $table->bigInteger('m_sub_menu_jenis_m_menu_jenis_id');
            $table->bigInteger('m_sub_menu_jenis_created_by');
            $table->timestampTz('m_sub_menu_jenis_created_at')->useCurrent();
            $table->bigInteger('m_sub_menu_jenis_updated_by')->nullable();
            $table->timestampTz('m_sub_menu_jenis_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_sub_menu_jenis_deleted_at')->nullable()->default(NULL);
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
