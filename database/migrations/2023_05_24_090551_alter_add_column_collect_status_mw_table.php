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
        Schema::table('m_w', function (Blueprint $table) {
            $table->integer('m_w_collect_status')->default(0)->after('m_w_currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_w', function (Blueprint $table) {
            $table->dropColumn(['m_w_tax_report']);
        });
    }
};
