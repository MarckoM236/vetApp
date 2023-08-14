<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identificacion')->unique();
            $table->string('lastName');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('role_id')->default(2);
            $table->boolean('status')->default(1);

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     * 
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('identificacion');
            $table->dropColumn('lastName');
            $table->dropColumn('photo');
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
            $table->dropColumn('status');
        });

    }
}
