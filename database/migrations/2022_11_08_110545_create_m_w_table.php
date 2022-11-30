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
        Schema::create('m_w', function (Blueprint $table) {
            $table->id('m_w_id');
            $table->string('m_w_nama');
            $table->string('m_w_code');
            $table->bigInteger('m_w_m_area_id');
            $table->bigInteger('m_w_m_w_jenis_id');
            $table->char('m_w_status')->default('1');
            $table->text('m_w_alamat');
            $table->bigInteger('m_w_m_jenis_nota_id');
            $table->bigInteger('m_w_m_pajak_id');
            $table->bigInteger('m_w_m_modal_tipe_id');
            $table->bigInteger('m_w_m_sc_id');
            $table->integer('m_w_decimal')->default(0);
            $table->string('m_w_pembulatan')->default('tidak');
            $table->char('m_w_currency',5)->default('Rp');
            $table->decimal('m_w_grab',3,2)->default(0); 
            $table->decimal('m_w_gojek',3,2)->default(0); 
            $table->char('m_menu_profit',1)->default('1');
            $table->bigInteger('m_w_created_by');
            $table->timestampTz('m_w_created_at')->useCurrent();
            $table->bigInteger('m_w_updated_by')->nullable();
            $table->timestampTz('m_w_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->timestampTz('m_w_deleted_at')->nullable()->default(NULL);
            $table->bigInteger('m_w_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_w');
    }
};
