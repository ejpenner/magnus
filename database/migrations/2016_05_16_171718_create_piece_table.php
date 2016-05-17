<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePieceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_path');
            $table->string('thumbnail_path');
            $table->string('title');
            $table->string('comment')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamp('published_at');
            $table->timestamps();
        });

        Schema::table('pieces', function (Blueprint $table) {
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.=-
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pieces');
    }
}
