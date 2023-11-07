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
        Schema::create('m_kategori_rekening', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('m_kategori_rekening_id');
            $table->string('m_kategori_rekening_name');
            $table->bigInteger('m_kategori_rekening_order')->nullable();
            $table->bigInteger('m_kategori_rekening_created_by');
            $table->bigInteger('m_kategori_rekening_updated_by')->nullable();
            $table->bigInteger('m_kategori_rekening_deleted_by')->nullable();
            $table->timestampTz('m_kategori_rekening_created_at')->useCurrent();
            $table->timestampTz('m_kategori_rekening_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_kategori_rekening_deleted_at')->nullable()->default(NULL);
            $table->text('m_kategori_rekening_client_target')->default(DB::raw('list_waroeng()'))->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_kategori_rekening');
    }
};
