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
        Schema::create('tb_trans_test', function (Blueprint $table) {
            $table->id('tb_trans_test_id');
            $table->string('tb_trans_test_rekap_beli_code');
            $table->bigInteger('tb_trans_test_m_produk_id');
            $table->string('tb_trans_test_m_produk_code');
            $table->string('tb_trans_test_m_produk_nama');
            $table->string('tb_trans_test_catatan');
            $table->decimal('tb_trans_test_qty',5,2);
            $table->decimal('tb_trans_test_harga',10,2);
            $table->decimal('tb_trans_test_disc',8,2)->nullable();
            $table->decimal('tb_trans_test_discrp')->nullable();
            $table->decimal('tb_trans_test_subtot',9,2);
            $table->string('tb_trans_test_terima')->nullable();
            $table->string('tb_trans_test_satuan_terima')->nullable();
            $table->bigInteger('tb_trans_test_waroeng_id');
            $table->string('tb_trans_test_waroeng');
            $table->bigInteger('tb_trans_test_created_by');
            $table->bigInteger('tb_trans_test_updated_by')->nullable();
            $table->bigInteger('tb_trans_test_deleted_by')->nullable();
            $table->timestampTz('tb_trans_test_created_at')->useCurrent();
            $table->timestampTz('tb_trans_test_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('tb_trans_test_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_trans_test');
    }
};
