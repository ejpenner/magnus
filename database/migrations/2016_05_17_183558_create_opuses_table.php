<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Magnus\Opus;

class CreateOpusesTable extends Migration
{
    /**
     * Create the opus table and it's pivot table
     * @return void
     */
    public function up()
    {
        Schema::create('opuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_path', 300);
            $table->string('thumbnail_path', 300);
            $table->string('preview_path', 300);
            $table->string('title', 255);
            $table->text('comment')->nullable();
            $table->string('slug', 255);
            $table->integer('views');
            $table->integer('daily_views');
            $table->timestamp('published_at');
            $table->timestamps();
        });

        Schema::table('opuses', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('gallery_opus', function (Blueprint $table) {
            $table->integer('opus_id')->unsigned();
            $table->integer('gallery_id')->unsigned();
            $table->foreign('opus_id')->references('id')->on('opuses')->onDelete('cascade');
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations and delete all the images
     * @return void
     */
    public function down()
    {
        $opuses = Opus::all();

        foreach ($opuses as $opus) {
             if($opus->deleteImages()) {
                 echo " deleted\n";
             }
        }

        Schema::drop('gallery_opus');
        Schema::drop('opuses');
    }
}
