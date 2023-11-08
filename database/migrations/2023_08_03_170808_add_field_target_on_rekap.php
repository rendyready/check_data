<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        #Rekap
        Schema::table('rekap_buka_laci', function (Blueprint $table) {
            $table->text('r_b_l_client_target')->nullable();
        });
        Schema::table('rekap_garansi', function (Blueprint $table) {
            $table->text('rekap_garansi_client_target')->nullable();
        });
        Schema::table('rekap_hapus_menu', function (Blueprint $table) {
            $table->text('r_h_m_client_target')->nullable();
        });
        Schema::table('rekap_hapus_transaksi', function (Blueprint $table) {
            $table->text('r_h_t_client_target')->nullable();
        });
        Schema::table('rekap_hapus_transaksi_detail', function (Blueprint $table) {
            $table->text('r_h_t_detail_client_target')->nullable();
        });
        Schema::table('rekap_lost_bill', function (Blueprint $table) {
            $table->text('r_l_b_client_target')->nullable();
        });
        Schema::table('rekap_lost_bill_detail', function (Blueprint $table) {
            $table->text('r_l_b_detail_client_target')->nullable();
        });
        Schema::table('rekap_member', function (Blueprint $table) {
            $table->text('rekap_member_client_target')->nullable();
        });
        Schema::table('rekap_modal', function (Blueprint $table) {
            $table->text('rekap_modal_client_target')->nullable();
        });
        Schema::table('rekap_modal_detail', function (Blueprint $table) {
            $table->text('rekap_modal_detail_client_target')->nullable();
        });
        Schema::table('rekap_mutasi_modal', function (Blueprint $table) {
            $table->text('r_m_m_client_target')->nullable();
        });
        Schema::table('rekap_uang_tips', function (Blueprint $table) {
            $table->text('r_u_t_client_target')->nullable();
        });
        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->uuid('r_t_tmp_transaction_id')->unique()->nullable();
            $table->text('r_t_client_target')->nullable();
        });
        Schema::table('rekap_transaksi_detail', function (Blueprint $table) {
            $table->text('r_t_detail_client_target')->nullable();
        });
        Schema::table('rekap_payment_transaksi', function (Blueprint $table) {
            $table->text('r_p_t_client_target')->nullable();
        });
        Schema::table('rekap_refund', function (Blueprint $table) {
            $table->text('r_r_client_target')->nullable();
        });
        Schema::table('rekap_refund_detail', function (Blueprint $table) {
            $table->text('r_r_detail_client_target')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekap_buka_laci', function (Blueprint $table) {
            $table->dropColumn(['r_b_l_client_target']);
        });
        Schema::table('rekap_garansi', function (Blueprint $table) {
            $table->dropColumn(['rekap_garansi_client_target']);
        });
        Schema::table('rekap_hapus_menu', function (Blueprint $table) {
            $table->dropColumn(['r_h_m_client_target']);
        });
        Schema::table('rekap_hapus_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_h_t_client_target']);
        });
        Schema::table('rekap_hapus_transaksi_detail', function (Blueprint $table) {
            $table->dropColumn(['r_h_t_detail_client_target']);
        });
        Schema::table('rekap_lost_bill', function (Blueprint $table) {
            $table->dropColumn(['r_l_b_client_target']);
        });
        Schema::table('rekap_lost_bill_detail', function (Blueprint $table) {
            $table->dropColumn(['r_l_b_detail_client_target']);
        });
        Schema::table('rekap_member', function (Blueprint $table) {
            $table->dropColumn(['rekap_member_client_target']);
        });
        Schema::table('rekap_modal', function (Blueprint $table) {
            $table->dropColumn(['rekap_modal_client_target']);
        });
        Schema::table('rekap_modal_detail', function (Blueprint $table) {
            $table->dropColumn(['rekap_modal_detail_client_target']);
        });
        Schema::table('rekap_mutasi_modal', function (Blueprint $table) {
            $table->dropColumn(['r_m_m_client_target']);
        });
        Schema::table('rekap_uang_tips', function (Blueprint $table) {
            $table->dropColumn(['r_u_t_client_target']);
        });
        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_t_client_target','r_t_tmp_transaction_id']);
        });
        Schema::table('rekap_transaksi_detail', function (Blueprint $table) {
            $table->dropColumn(['r_t_detail_client_target']);
        });
        Schema::table('rekap_payment_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_p_t_client_target']);
        });
        Schema::table('rekap_refund', function (Blueprint $table) {
            $table->dropColumn(['r_r_client_target']);
        });
        Schema::table('rekap_refund_detail', function (Blueprint $table) {
            $table->dropColumn(['r_r_detail_client_target']);
        });
    }
};
