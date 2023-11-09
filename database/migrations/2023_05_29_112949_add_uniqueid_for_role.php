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
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->uuid('r_h_p_id')->default(DB::raw('gen_random_uuid()'))->unique();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->uuid('m_h_p_id')->default(DB::raw('gen_random_uuid()'))->unique();
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->uuid('m_h_r_id')->default(DB::raw('gen_random_uuid()'))->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->dropColumn(['r_h_p_id']);
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropColumn(['m_h_p_id']);
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropColumn(['m_h_r_id']);
        });
    }
};
