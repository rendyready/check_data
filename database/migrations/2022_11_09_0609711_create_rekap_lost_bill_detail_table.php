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
        Schema::create('rekap_lost_bill_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_l_b_detail_id')->unique();
            // $table->bigInteger('r_l_b_detail_sync_id')->nullable();
            $table->string('r_l_b_detail_r_l_b_id');
            $table->unsignedBigInteger('r_l_b_detail_m_produk_id');
            $table->string('r_l_b_detail_m_produk_nama')->nullable();
            $table->decimal('r_l_b_detail_price', 15,2);
            $table->integer('r_l_b_detail_qty');
            $table->decimal('r_l_b_detail_nominal', 15,2)->default(0);
            $table->decimal('r_l_b_detail_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_l_b_detail_nominal_sc', 15,2)->default(0);
            $table->decimal('r_l_b_detail_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_l_b_detail_nominal_sharing_profit_out', 15,2)->default(0);
            $table->char('r_l_b_detail_status_sync', 10)->default('0');
            $table->bigInteger('r_l_b_detail_created_by');
            $table->bigInteger('r_l_b_detail_updated_by')->nullable();
            $table->bigInteger('r_l_b_detail_deleted_by')->nullable();
            $table->timestampTz('r_l_b_detail_created_at')->useCurrent();
            $table->timestampTz('r_l_b_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_l_b_detail_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_lost_bill_detail');
    }
};
