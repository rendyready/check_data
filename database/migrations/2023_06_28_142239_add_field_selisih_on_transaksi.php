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
        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->decimal('r_t_nominal_selisih', 15,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekap_transaksi', function (Blueprint $table) {
            $table->dropColumn(['r_t_nominal_selisih']);
        });
    }
};
