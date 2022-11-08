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
        Schema::create('m_menu_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('m_menu_jenis_nama');
            $table->string('m_menu_jenis_urut')->unique();
            $table->enum('m_menu_jenis_odcr55',['minum','makan',null])->default('makan')->nullable();
            $table->bigInteger('m_menu_jenis_created_by');
            $table->timestamp('m_menu_jenis_created_at')->useCurrent();
            $table->bigInteger('m_menu_jenis_updated_by')->nullable();
            $table->timestamp('m_menu_jenis_updated_at')->useCurrentOnUpdate();
            $table->softDeletes('m_menu_jenis_deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_menu_jenis');
    }
};
