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
        Schema::create('rekap_lost_bill', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_l_b_id')->unique();
            // $table->bigInteger('r_l_b_sync_id')->nullable();
            $table->string('r_l_b_rekap_modal_id');
            // $table->string('r_l_b_tmp_transaction_id')->comment('Untuk cek duplikasi input');
            $table->date('r_l_b_tanggal');
            $table->time('r_l_b_jam');
            $table->string('r_l_b_nota_code');
            $table->string('r_l_b_bigboss');
            $table->decimal('r_l_b_nominal', 15,2)->default(0);
            $table->decimal('r_l_b_nominal_pajak', 15,2)->default(0);
            $table->decimal('r_l_b_nominal_sc', 15,2)->default(0);
            $table->decimal('r_l_b_nominal_sharing_profit_in', 15,2)->default(0);
            $table->decimal('r_l_b_nominal_sharing_profit_out', 15,2)->default(0);
            $table->string('r_l_b_keterangan');
            $table->unsignedBigInteger('r_l_b_m_w_id');
            $table->string('r_l_b_m_w_nama')->nullable();
            $table->unsignedBigInteger('r_l_b_m_area_id');
            $table->string('r_l_b_m_area_nama')->nullable();
            $table->char('r_l_b_status_sync', 10)->default('0');
            $table->unsignedBigInteger('r_l_b_approved_by')->nullable();
            $table->bigInteger('r_l_b_created_by');
            $table->bigInteger('r_l_b_updated_by')->nullable();
            $table->bigInteger('r_l_b_deleted_by')->nullable();
            $table->timestampTz('r_l_b_created_at')->useCurrent();
            $table->timestampTz('r_l_b_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_l_b_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_lost_bill');
    }
};
