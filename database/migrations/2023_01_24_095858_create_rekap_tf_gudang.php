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
        Schema::create('rekap_tf_gudang', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('rekap_tf_gudang_id');
            $table->string('rekap_tf_gudang_code');
            $table->string('rekap_tf_gudang_asal_code'); 
            $table->string('rekap_tf_gudang_tujuan_code');
            $table->datetime('rekap_tf_gudang_tgl_kirim');
            $table->date('rekap_tf_gudang_tgl_terima')->nullable();
            $table->decimal('rekap_tf_gudang_grand_tot',16,2);
            $table->bigInteger('rekap_tf_gudang_created_by');
            $table->bigInteger('rekap_tf_gudang_updated_by')->nullable();
            $table->bigInteger('rekap_tf_gudang_deleted_by')->nullable();
            $table->timestampTz('rekap_tf_gudang_created_at')->useCurrent();
            $table->timestampTz('rekap_tf_gudang_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_tf_gudang_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_tf_gudang');
    }
};
