<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Opus;

class CreateOpusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_path');
            $table->string('thumbnail_path');
            $table->string('title');
            $table->text('comment')->nullable();
            $table->integer('views');
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
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $opuses = Opus::all();

        foreach ($opuses as $opus) {
            echo public_path().'/'.$opus->getImage();

             if($opus->deleteImages()) {
                 echo " deleted\n";
             }
        }

        Schema::drop('gallery_opus');
        Schema::drop('opuses');
    }
}
