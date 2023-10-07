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
        if (!Schema::hasColumn('tmp_transaction', 'tmp_transaction_qrcode_datetime')) {
            Schema::table('tmp_transaction', function (Blueprint $table) {
                $table->dateTime('tmp_transaction_qrcode_datetime')->nullable();
            });
        }
        if (!Schema::hasColumn('tmp_transaction', 'tmp_transaction_kitchen_done_time')) {
            Schema::table('tmp_transaction', function (Blueprint $table) {
                $table->time('tmp_transaction_kitchen_done_time')->nullable();
            });
        }
        // Schema::table('tmp_transaction', function (Blueprint $table) {
        //     $table->dateTime('tmp_transaction_qrcode_datetime')->nullable();
        //     // $table->time('tmp_transaction_kitchen_order_datetime')->nullable();
        //     $table->time('tmp_transaction_kitchen_done_time')->nullable();
        // });
        if (!Schema::hasColumn('rekap_transaksi', 'r_t_qrcode_datetime')) {
            Schema::table('rekap_transaksi', function (Blueprint $table) {
                $table->dateTime('r_t_qrcode_datetime')->nullable();
            });
        }
        if (!Schema::hasColumn('rekap_transaksi', 'r_t_tmpcr_datetime')) {
            Schema::table('rekap_transaksi', function (Blueprint $table) {
                $table->dateTime('r_t_tmpcr_datetime')->nullable();
            });
        }
        if (!Schema::hasColumn('rekap_transaksi', 'r_t_kitchen_done_time')) {
            Schema::table('rekap_transaksi', function (Blueprint $table) {
                $table->time('r_t_kitchen_done_time')->nullable();
            });
        }
        // Schema::table('rekap_transaksi', function (Blueprint $table) {
        //     $table->dateTime('r_t_qrcode_datetime')->nullable();
        //     $table->dateTime('r_t_tmpcr_datetime')->nullable();
        //     // $table->time('r_t_kitchen_order_time')->nullable();
        //     $table->time('r_t_kitchen_done_time')->nullable();
        // });
        if (!Schema::hasColumn('m_w', 'm_w_telp')) {
            Schema::table('m_w', function (Blueprint $table) {
                $table->string('m_w_telp')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tmp_transaction', function (Blueprint $table) {
            $table->dropColumn(['tmp_transaction_qrcode_datetime','tmp_transaction_kitchen_done_time']);
        });

        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_t_qrcode_datetime','r_t_tmpcr_datetime','r_t_kitchen_done_time']);
        });

        Schema::table('m_w', function (Blueprint $table) {
            $table->dropColumn('m_w_telp');
        });
    }
};
