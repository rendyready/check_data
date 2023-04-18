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
        Schema::table('m_divisi', function (Blueprint $table) {
            $table->renameColumn('m_group_produk_created_by','m_divisi_created_by');
            $table->renameColumn('m_group_produk_created_by_name','m_divisi_created_by_name');
            $table->renameColumn('m_group_produk_updated_by','m_divisi_updated_by');
            $table->renameColumn('m_group_produk_deleted_by','m_divisi_deleted_by');
            $table->renameColumn('m_group_produk_created_at','m_divisi_created_at');
            $table->renameColumn('m_group_produk_updated_at','m_divisi_updated_at');
            $table->renameColumn('m_group_produk_deleted_at','m_divisi_deleted_at');
            $table->string("m_divisi_status_sync", 20)->default('send');

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
