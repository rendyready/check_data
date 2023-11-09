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
        Schema::table('m_produk', function (Blueprint $table) {
            $table->string('m_produk_qr')->default('ya');
        });

        Schema::table('m_menu_harga', function (Blueprint $table) {
            $table->string('m_menu_harga_qr_status')->default('ya');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_produk', function (Blueprint $table) {
            $table->dropColumn('m_produk_qr');
        });

        Schema::table('m_menu_harga', function (Blueprint $table) {
            $table->dropColumn('m_menu_harga_qr_status');
        });
    }
};
