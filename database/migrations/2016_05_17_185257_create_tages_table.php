<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 60)->unique();
            $table->index('name', 'tag_index');
        });
        
        Schema::create('opus_tag', function (Blueprint $table)
        {
            $table->integer('opus_id')->unsigned();
            $table->foreign('opus_id')->references('id')->on('opuses')->onDelete('cascade');
            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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

        Schema::table('tags', function(Blueprint $table)
        {
            $table->dropIndex('tag_index');
        });

        Schema::drop('opus_tag');
        Schema::drop('tags');
    }
}
