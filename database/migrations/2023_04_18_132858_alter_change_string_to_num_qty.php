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
        DB::statement("ALTER TABLE rph_detail_menu ALTER rph_detail_menu_qty TYPE NUMERIC USING (rph_detail_menu_qty::numeric);");
        DB::statement("ALTER TABLE m_resep_detail ALTER m_resep_detail_bb_qty TYPE NUMERIC USING (m_resep_detail_bb_qty::numeric);");
        DB::statement("ALTER TABLE rph_detail_bb ALTER rph_detail_bb_qty TYPE NUMERIC USING (rph_detail_bb_qty::numeric);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    }
};
