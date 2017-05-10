<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name', 64);
            $table->string('role_code',64);
            $table->integer('level');
            $table->index(['role_name','role_code','level'], 'roles_index');
            $table->timestamps();
        });

        Schema::create('user_roles', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->index(['user_id','role_id'],'user_roles_index');
            $table->timestamps();
        });

        Schema::table('user_roles', function (Blueprint $table){
           $table->foreign('user_id','user_roles_user_id')->references('id')->on('users');
           $table->foreign('role_id', 'user_roles_role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function(Blueprint $table)
        {

            $table->dropIndex('roles_index');
        });

        Schema::table('user_roles', function(Blueprint $table)
        {
            $table->dropForeign('user_roles_user_id');
            $table->dropForeign('user_roles_role_id');
            $table->dropIndex('user_roles_index');
        });
        Schema::drop('user_roles');
        Schema::drop('roles');
    }
}
