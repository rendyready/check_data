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
        Schema::create('m_menu_harga', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('m_menu_harga_id');
            $table->decimal('m_menu_harga_nominal', 15, 2);
            $table->unsignedBigInteger('m_menu_harga_m_jenis_nota_id');
            $table->unsignedBigInteger('m_menu_harga_m_produk_id');
            $table->char('m_menu_harga_status')->default('0');
            $table->char('m_menu_harga_tax_status')->default('0');
            $table->char('m_menu_harga_sc_status')->default('0');
            $table->bigInteger('m_menu_harga_created_by');
            $table->bigInteger('m_menu_harga_updated_by')->nullable();
            $table->bigInteger('m_menu_harga_deleted_by')->nullable();
            $table->timestampTz('m_menu_harga_created_at')->useCurrent();
            $table->timestampTz('m_menu_harga_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_menu_harga_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_menu_harga');
    }
};
