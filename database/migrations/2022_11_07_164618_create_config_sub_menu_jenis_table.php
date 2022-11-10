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
        Schema::create('config_sub_menu_jenis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('config_sub_menu_jenis_m_menu_id');
            $table->bigInteger('config_sub_menu_jenis_m_kategori_id');
            $table->bigInteger('config_sub_menu_jenis_created_by');
            $table->timestampTz('config_sub_menu_jenis_created_at')->useCurrent();
            $table->timestampTz('config_sub_menu_jenis_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('config_sub_menu_jenis_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_menu_kategori');
    }
};
