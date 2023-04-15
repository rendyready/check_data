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
        DB::statement("ALTER TABLE rph ALTER rph_m_w_code TYPE BIGINT USING (rph_m_w_code::integer);");

        Schema::table('rph', function (Blueprint $table) {
            $table->renameColumn('rph_m_w_code', 'rph_m_w_id');
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
