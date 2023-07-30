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
            $table->string('m_produk_image',255)->nullable();
        });

        Schema::table('m_menu_harga', function (Blueprint $table) {
            $table->decimal('m_menu_harga_package',10,2)->nullable();
        });

        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->decimal('r_t_detail_package_price',10,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_t_detail_package_price']);
        });
        Schema::table('m_menu_harga', function (Blueprint $table) {
            $table->dropColumn(['m_menu_harga_package']);
        });
        Schema::table('m_produk', function (Blueprint $table) {
            $table->dropColumn(['m_produk_image']);
        });
    }
};
