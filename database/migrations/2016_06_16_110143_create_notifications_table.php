<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('handle'); //comment, opus, reply, private message, etc
            $table->integer('comment_id')->unsigned();
            $table->integer('opus_id')->unsigned();
            $table->integer('message_id')->unsigned();
            $table->string('content');
            $table->boolean('read');
            $table->timestamps();
        });

        Schema::create('notification_user', function (Blueprint $table){
            $table->integer('notification_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('notification_user', function (Blueprint $table){
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_user');
        Schema::drop('notifications');
    }
}
