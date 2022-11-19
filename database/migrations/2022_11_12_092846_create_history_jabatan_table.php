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
        Schema::create('history_jabatan', function (Blueprint $table) {
            $table->id('history_jabatan_id');
            $table->bigInteger('history_jabatan_m_karyawan_id');
            $table->bigInteger('history_jabatan_m_jabatan_id');
            $table->bigInteger('history_jabatan_m_w_id');
            $table->date('history_jabatan_mulai');  
            $table->date('history_jabatan_selesai')->nullable()->default(NULL);  
            $table->bigInteger('history_jabatan_created_by');
            $table->bigInteger('history_jabatan_updated_by')->nullable();
            $table->timestampTz('history_jabatan_created_at')->useCurrent();
            $table->timestampTz('history_jabatan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('history_jabatan_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_jabatan');
    }
};
