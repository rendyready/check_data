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
        Schema::create('m_jenis_belanja', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('m_jenis_belanja_id')->unsigned()->nullable();
            $table->string('m_jenis_belanja_nama')->nullable();
            $table->bigInteger('m_jenis_belanja_created_by');
            $table->bigInteger('m_jenis_belanja_updated_by')->nullable();
            $table->timestampTz('m_jenis_belanja_created_at')->useCurrent();
            $table->timestampTz('m_jenis_belanja_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->text('m_jenis_belanja_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
