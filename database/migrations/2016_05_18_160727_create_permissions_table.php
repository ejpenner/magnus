<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('schema_name');
            $table->string('role');
            $table->integer('role_id');
            $table->boolean('create');
            $table->boolean('read');
            $table->boolean('edit');
            $table->boolean('destroy');
            $table->boolean('create_all');
            $table->boolean('read_all');
            $table->boolean('edit_all');
            $table->boolean('destroy_all');
            $table->boolean('gallery_all');
            $table->boolean('piece_all');
            $table->boolean('comment_all');
            $table->boolean('private_message_access');
            $table->boolean('banned');
            $table->timestamps();
        });

        // add FK to users
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropForeign('users_permission_id_foreign');
        });

        Schema::drop('permissions');
    }
}
