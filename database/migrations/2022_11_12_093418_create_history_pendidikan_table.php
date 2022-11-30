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
        Schema::create('history_pendidikan', function (Blueprint $table) {
            $table->id('history_pendidikan_id');
            $table->char('history_pendidikan_m_karyawan_id');
            $table->char('history_pendidikan_jenjang', 20);
            $table->string('history_pendidikan_institut');
            $table->string('history_pendidikan_jurusan')->nullable();
            $table->char('history_pendidikan_tahun_masuk', 4)->nullable();
            $table->char('history_pendidikan_tahun_lulus', 4)->nullable();
            $table->decimal('history_pendidikan_nilai')->nullable()->default(NULL);
            $table->bigInteger('history_pendidikan_created_by');
            $table->bigInteger('history_pendidikan_updated_by')->nullable();
            $table->bigInteger('history_pendidikan_deleted_by')->nullable();
            $table->timestampTz('history_pendidikan_created_at')->useCurrent();
            $table->timestampTz('history_pendidikan_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('history_pendidikan_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_pendidikan');
    }
};
