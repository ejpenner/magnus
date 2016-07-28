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
            //$table->integer('opus_id')->unsigned()->nullable();;
            $table->string('commentable_type');
            $table->integer('commentable_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            //$table->integer('profile_id')->unsigned()->nullable();
            //$table->integer('journal_id')->unsigned()->nullable();
            $table->boolean('deleted')->nullable();
            $table->text('body');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('opus_id')->references('id')->on('opuses')->onDelete('cascade');
            //$table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            //$table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            //$table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}
