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
        Schema::create('rekap_trans_jualbeli_detail', function (Blueprint $table) {
            $table->id('id');
            $table->string('r_t_jb_detail_id')->unique();
            $table->string('r_t_jb_detail_r_t_jb_id');
            $table->unsignedBigInteger('r_t_jb_detail_m_produk_id');
            $table->string('r_t_jb_detail_m_produk_nama');
            $table->string('r_t_jb_detail_catatan');
            $table->decimal('r_t_jb_detail_qty',5,2);
            $table->decimal('r_t_jb_detail_harga',10,2);
            $table->decimal('r_t_jb_detail_disc',8,2)->nullable();
            $table->decimal('r_t_jb_detail_nominal_disc')->nullable();
            $table->decimal('r_t_jb_detail_subtot_beli',9,2);
            $table->bigInteger('r_t_jb_detail_m_w_id');
            $table->string('r_t_jb_detail_terima_qty')->nullable();
            $table->bigInteger('r_t_jb_detail_satuan_id')->nullable();
            $table->string('r_t_jb_detail_satuan_terima')->nullable();
            $table->bigInteger('r_t_jb_detail_created_by');
            $table->bigInteger('r_t_jb_detail_updated_by')->nullable();
            $table->bigInteger('r_t_jb_detail_deleted_by')->nullable();
            $table->timestampTz('r_t_jb_detail_created_at')->useCurrent();
            $table->timestampTz('r_t_jb_detail_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('r_t_jb_detail_deleted_at')->nullable()->default(NULL);
            $table->text('r_t_jb_detail_client_target')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_trans_jualbeli_detail');
    }
};
