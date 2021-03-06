<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('common__permissions', function (Blueprint $table) {
            $table->foreign('user_id', 'permissions__user_id_foreign')
                ->references('id')
                ->on('common__users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('common__permissions', function (Blueprint $table) {
            $table->dropForeign('permissions__user_id_foreign');
        });
    }
}
