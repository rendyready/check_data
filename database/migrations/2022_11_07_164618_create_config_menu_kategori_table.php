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
        Schema::create('config_menu_kategori', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('config_menu_kategori_m_menu_id');
            $table->bigInteger('config_menu_kategori_m_kategori_id');
            $table->bigInteger('config_menu_kategori_created_by');
            $table->timestampTz('config_menu_kategori_created_at')->useCurrent();
            $table->timestampTz('config_menu_kategori_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('config_menu_kategori_deleted_at')->nullable()->default(NULL);
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
