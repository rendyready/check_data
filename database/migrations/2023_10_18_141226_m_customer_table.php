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
        Schema::create('m_customer', function (Blueprint $table) {
            $table->string('m_customer_id')->nullable();
            $table->string('m_customer_code');
            $table->string('m_customer_nama',255);
            $table->string('m_customer_jth_tempo');
            $table->string('m_customer_alamat',255);
            $table->string('m_customer_kota',100);
            $table->string('m_customer_telp',25);
            $table->string('m_customer_ket',255);
            $table->string('m_customer_rek');
            $table->string('m_customer_rek_nama');
            $table->string('m_customer_bank_nama');
            $table->decimal('m_customer_saldo_awal',8,2);
            $table->bigInteger('m_customer_created_by');
            $table->bigInteger('m_customer_updated_by')->nullable();
            $table->bigInteger('m_customer_deleted_by')->nullable();
            $table->timestampTz('m_customer_created_at')->useCurrent();
            $table->timestampTz('m_customer_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_customer_deleted_at')->nullable()->default(NULL);
            $table->string('m_customer_parent_id')->nullable();
            $table->unsignedBigInteger('m_customer_m_w_id')->nullable();
            $table->text('m_customer_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_customer');
    }
};
