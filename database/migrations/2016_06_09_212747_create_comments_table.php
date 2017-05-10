<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('commentable_type');
            $table->integer('commentable_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->boolean('deleted')->nullable();
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id','fk_comments_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function($table)
        {
            $table->dropForeign('fk_comments_user_id');
        });
        Schema::drop('comments');
    }
}
