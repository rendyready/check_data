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
        Schema::create('m_group_produk', function (Blueprint $table) {
            $table->id('id');
            $table->string('m_group_produk_id')->unique();
            $table->string('m_group_produk_parent_id')->nullable();
            $table->string('m_group_produk_name');
            $table->string('m_group_produk_m_divisi_id');
            $table->string('m_group_produk_m_divisi_name');
            $table->jsonb('m_group_produk_produk_list')->nullable()->comment('list of produk id');
            $table->bigInteger('m_group_produk_created_by');
            $table->string('m_group_produk_created_by_name');
            $table->bigInteger('m_group_produk_updated_by')->nullable();
            $table->bigInteger('m_group_produk_deleted_by')->nullable();
            $table->timestampTz('m_group_produk_created_at')->useCurrent();
            $table->timestampTz('m_group_produk_updated_at')->useCurrentOnUpdate()->nullable()->default(NULL);
            $table->timestampTz('m_group_produk_deleted_at')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_group_produk');
    }
};
