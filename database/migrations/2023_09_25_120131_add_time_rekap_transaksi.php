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
        Schema::table('tmp_transaction', function (Blueprint $table) {
            $table->dateTime('tmp_transaction_qrcode_datetime')->nullable();
            // $table->time('tmp_transaction_kitchen_order_datetime')->nullable();
            $table->time('tmp_transaction_kitchen_done_time')->nullable();
        });
        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->dateTime('r_t_qrcode_datetime')->nullable();
            $table->dateTime('r_t_tmpcr_datetime')->nullable();
            // $table->time('r_t_kitchen_order_time')->nullable();
            $table->time('r_t_kitchen_done_time')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tmp_transaction', function (Blueprint $table) {
            $table->dropColumn(['tmp_transaction_qrcode_datetime','tmp_transaction_kitchen_done_datetime']);
        });

        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_t_qrcode_datetime','r_t_tmpcr_datetime','r_t_kitchen_done_datetime']);
        });
    }
};
