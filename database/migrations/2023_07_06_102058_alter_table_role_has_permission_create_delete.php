<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::dropIfExists('role_has_permissions');
        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->bigInteger('permission_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->string('r_h_p_status_sync')->default('send');
            $table->uuid('r_h_p_id')->default(DB::raw('gen_random_uuid()'))->unique();
            $table->text('r_h_p_client_target')->default(DB::raw('list_waroeng()'))->nullable();
        });
        Schema::dropIfExists('model_has_roles');
        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->string('model_type');
            $table->bigInteger('model_id')->unsigned();
            $table->string('m_h_r_status_sync')->default('send');
            $table->uuid('m_h_r_id')->default(DB::raw('gen_random_uuid()'))->unique();
            $table->text('m_h_r_client_target')->default(DB::raw('list_waroeng()'))->nullable();
            $table->index('model_type');
            $table->index('role_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('role_has_permissions');
    }
};
