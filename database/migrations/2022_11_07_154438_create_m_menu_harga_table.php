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
        Schema::create('m_menu_harga', function (Blueprint $table) {
            $table->id();
            $table->decimal('m_menu_harga_nominal', 15, 2);
            $table->bigInteger('m_menu_harga_m_jenis_nota_id');
            $table->bigInteger('m_menu_harga_m_menu_id');
            $table->char('m_menu_harga_status')->default(0);
            $table->bigInteger('m_menu_harga_created_by');
            $table->timestamp('m_menu_harga_created_at')->useCurrent();
            $table->bigInteger('m_menu_harga_updated_by')->nullable();
            $table->timestamp('m_menu_harga_updated_at')->nullable()->useCurrentOnUpdate()->default(NULL);
            $table->softDeletes('m_menu_harga_deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_menu_harga');
    }
};
