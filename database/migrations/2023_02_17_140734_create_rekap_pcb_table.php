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
        Schema::create('rekap_pcb', function (Blueprint $table) {
            $table->id('rekap_pcb');
            $table->string('rekap_pcb_code');
            $table->bigInteger('rekap_pcb_gudang_asal_id');
            $table->string('rekap_pcb_waroeng');
            $table->string('rekap_pcb_aksi');
            $table->bigInteger('rekap_pcb_brg_asal_id');
            $table->string('rekap_pcb_brg_asal_nama');
            $table->bigInteger('rekap_pcb_brg_asal_satuan_id');
            $table->string('rekap_pcb_brg_asal_satuan');
            $table->string('rekap_pcb_brg_asal_isi');
            $table->string('rekap_pcb_brg_asal_qty',15,2);
            $table->decimal('rekap_pcb_brg_asal_hpp');
            $table->bigInteger('rekap_pcb_brg_hasil_id');
            $table->string('rekap_pcb_brg_hasil_nama');
            $table->bigInteger('rekap_pcb_brg_hasil_satuan_id');
            $table->string('rekap_pcb_brg_hasil_satuan');
            $table->string('rekap_pcb_brg_hasil_isi');
            $table->string('rekap_pcb_brg_hasil_qty',15,2);
            $table->decimal('rekap_pcb_brg_hasil_hpp');
            $table->bigInteger('rekap_pcb_created_by');
            $table->bigInteger('rekap_pcb_updated_by')->nullable();
            $table->bigInteger('rekap_pcb_deleted_by')->nullable();
            $table->timestampTz('rekap_pcb_created_at')->useCurrent();
            $table->timestampTz('rekap_pcb_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_pcb_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_pcb');
    }
};
