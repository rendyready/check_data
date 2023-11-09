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
        if (!Schema::hasColumn('rekap_garansi', 'rekap_garansi_package_price')) {
            Schema::table('rekap_garansi', function (Blueprint $table) {
                $table->decimal('rekap_garansi_package_price',8,2)->default(0);
            });
        }
        if (!Schema::hasColumn('rekap_refund_detail', 'r_r_detail_package_price')) {
            Schema::table('rekap_refund_detail', function (Blueprint $table) {
                $table->decimal('r_r_detail_package_price',8,2)->default(0);
            });
        }
        if (!Schema::hasColumn('m_payment_method', 'm_payment_method_m_rekening_id')) {
            Schema::table('m_payment_method', function (Blueprint $table) {
                $table->unsignedBigInteger('m_payment_method_m_rekening_id')->nullable();
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
        if (Schema::hasColumn('rekap_garansi', 'rekap_garansi_package_price')) {
            Schema::table('rekap_garansi', function (Blueprint $table) {
                $table->dropColumn('rekap_garansi_package_price');
            });
        }
        if (Schema::hasColumn('rekap_refund_detail', 'r_r_detail_package_price')) {
            Schema::table('rekap_refund_detail', function (Blueprint $table) {
                $table->dropColumn('r_r_detail_package_price');
            });
        }
        if (Schema::hasColumn('m_payment_method', 'm_payment_method_m_rekening_id')) {
            Schema::table('m_payment_method', function (Blueprint $table) {
                $table->dropColumn('m_payment_method_m_rekening_id');
            });
        }
    }
};
