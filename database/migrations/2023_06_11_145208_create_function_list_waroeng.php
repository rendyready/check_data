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
        DB::unprepared('
            CREATE OR REPLACE FUNCTION list_waroeng()
            RETURNS TEXT AS $waroeng$
            DECLARE
                waroeng TEXT;
            BEGIN
            SELECT REPLACE(array_agg('."':'||new_cab.m_w_id||':'".')::TEXT,'."',',''".') FROM (SELECT * FROM m_w ORDER BY m_w_id ASC) AS new_cab INTO waroeng;
            RETURN waroeng;
            END;
            $waroeng$ LANGUAGE plpgsql;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP FUNCTION list_waroeng;");
    }
};
