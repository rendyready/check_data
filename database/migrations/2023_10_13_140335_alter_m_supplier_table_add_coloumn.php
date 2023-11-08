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
        Schema::dropIfExists('m_supplier');
        Schema::create('m_supplier', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_supplier_id')->unsigned()->nullable();
            $table->bigInteger('m_supplier_parent_id')->unsigned()->nullable();
            $table->unsignedBigInteger('m_supplier_m_w_id')->nullable();
            $table->string('m_supplier_code');
            $table->string('m_supplier_nama');
            $table->string('m_supplier_alamat')->nullable();
            $table->string('m_supplier_kota')->nullable();
            $table->string('m_supplier_telp')->nullable();
            $table->string('m_supplier_ket')->nullable();
            $table->integer('m_supplier_jth_tempo')->default(0)->comment('batas bayar in days');
            $table->string('m_supplier_rek_number');
            $table->string('m_supplier_rek_nama');
            $table->string('m_supplier_bank_nama');
            $table->decimal('m_supplier_saldo_awal',15,2)->default(0);
            $table->bigInteger('m_supplier_created_by');
            $table->bigInteger('m_supplier_updated_by')->nullable();
            $table->bigInteger('m_supplier_deleted_by')->nullable();
            $table->timestampTz('m_supplier_created_at')->useCurrent();
            $table->timestampTz('m_supplier_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_supplier_deleted_at')->nullable()->default(NULL);
            $table->text('m_supplier_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_supplier');
    }
};
