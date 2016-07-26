<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('sex')->nullable();
            $table->boolean('show_sex')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('dob_day')->nullable();
            $table->string('dob_month')->nullable();
            $table->integer('dob_year')->nullable();
            $table->string('show_dob')->nullable();
            $table->integer('per_page')->nullable();
            $table->integer('profile_opus_per_page')->nullable();
            $table->integer('profile_favorites_per_page')->nullable();
            $table->timestamps();
        });

        Schema::table('preferences', function (Blueprint $table) {
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
        Schema::drop('preferences');
    }
}
