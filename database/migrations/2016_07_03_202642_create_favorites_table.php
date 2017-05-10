<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opus_id')->unsigned();
            $table->integer('collection_id')->unsigned()->nullable();
            $table->foreign('opus_id')->references('id')->on('opuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('favorite_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('favorite_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('favorite_id')->references('id')->on('favorites')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('notifications', function (Blueprint $table){
            $table->index(['favorite_id'], 'favorite_notification_index');
            $table->foreign('favorite_id')->references('id')->on('favorites')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table){
            $table->dropForeign('notifications_favorite_id_foreign');
            $table->dropIndex('favorite_notification_index');
        });

        Schema::drop('favorite_user');
        Schema::drop('favorites');
    }
}
