<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 30);
            $table->string('name', 30)->nullable();
            $table->string('slug', 128)->nullable();
            $table->string('directory', 30)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('email', 60)->unique();
            $table->string('password');
            $table->string('timezone')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['username','email'], 'user_table_index');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->deleteDirectories();

        //File::cleanDirectory(public_path('art'));

        Schema::drop('users');
    }

    protected function deleteDirectories() {
        $users = \Magnus\User::all();

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('user_table_index');
        });

        foreach($users as $user) {
            $user->deleteAvatarFile();
            \Magnus\Helpers\Helpers::deleteDirectories($user->username);
        }
    }

}
