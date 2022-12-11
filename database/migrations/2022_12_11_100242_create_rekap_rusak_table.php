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
        Schema::create('rekap_rusak', function (Blueprint $table) {
            $table->id('rekap_rusak_id');
            $table->string('rekap_rusak_code'); //id user+ urutan
            $table->date('rekap_rusak_tgl');
            $table->bigInteger('rekap_rusak_m_w_id');
            $table->bigInteger('rekap_rusak_created_by');
            $table->bigInteger('rekap_rusak_updated_by')->nullable();
            $table->bigInteger('rekap_rusak_deleted_by')->nullable();
            $table->timestampTz('rekap_rusak_created_at')->useCurrent();
            $table->timestampTz('rekap_rusak_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('rekap_rusak_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_rusak');
    }
};
