<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('handle'); //comment, opus, reply, private message, etc
            $table->integer('comment_id')->nullable()->unsigned();
            $table->integer('opus_id')->nullable()->unsigned();
            $table->integer('private_message_id')->nullable()->unsigned();
            $table->integer('favorite_id')->nullable()->unsigned();
            $table->integer('watcher_user_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('opus_id')->references('id')->on('opuses')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('watcher_user_id')->references('id')->on('users')->onDelete('cascade');
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
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_user');
        Schema::drop('notifications');
    }
}
