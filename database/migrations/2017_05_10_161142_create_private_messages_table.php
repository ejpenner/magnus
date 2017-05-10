<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('rawBody');
            $table->text('renderedBody');



            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('private_messages', function($table)
        {
            // FKs
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['user_id'], 'private_message_index');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('private_messages', function($table)
        {
            //$table->dropForeign(['user_id','conversation_id']); // Drop foreign key 'user_id' from 'posts' table
            //$table->dropIndex('private_message_index'); // Drop basic index in 'state' from 'geo' table
        });

        Schema::drop('private_messages');
    }
}
