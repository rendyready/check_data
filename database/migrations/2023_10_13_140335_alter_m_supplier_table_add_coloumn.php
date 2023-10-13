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
        Schema::table('m_supplier', function (Blueprint $table) {
            $table->string('m_supplier_parent_id')->nullable();
            $table->unsignedBigInteger('m_supplier_m_w_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_supplier', function (Blueprint $table) {
            $table->dropColumn('m_supplier_parent_id');
            $table->dropColumn('m_supplier_m_w_id');
        });
    }
};
