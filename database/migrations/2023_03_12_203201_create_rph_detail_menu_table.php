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
        Schema::create('rph_detail_menu', function (Blueprint $table) {
            $table->id('id');
            $table->string('rph_detail_menu_id');
            $table->string('rph_detail_menu_rph_code');
            $table->string('rph_detail_menu_m_produk_code');
            $table->string('rph_detail_menu_m_produk_nama');
            $table->string('rph_detail_menu_qty');
            $table->bigInteger('rph_detail_menu_created_by');
            $table->bigInteger('rph_detail_menu_updated_by')->nullable();
            $table->bigInteger('rph_detail_menu_deleted_by')->nullable();
            $table->timestampTz('rph_detail_menu_created_at')->useCurrent();
            $table->timestampTz('rph_detail_menu_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('rph_detail_menu_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rph_detail_menu');
    }
};
