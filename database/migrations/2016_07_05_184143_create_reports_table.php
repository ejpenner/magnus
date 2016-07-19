<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reporter_user_id')->unsigned();
            $table->integer('reported_user_id')->unsigned();
            $table->integer('admin_user_id')->unsigned()->nullable();
            $table->integer('opus_id')->unsigned()->nullable();
            $table->integer('comment_id')->unsigned()->nullable();
            $table->string('report_code');
            $table->string('report_status');
            $table->string('action_code');
            $table->string('report_body', 1000);
            $table->timestamps();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->foreign('reporter_user_id')->references('id')->on('users');
            $table->foreign('reported_user_id')->references('id')->on('users');
            $table->foreign('admin_user_id')->references('id')->on('users');
            $table->foreign('opus_id')->references('id')->on('opuses');
            $table->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reports');
    }
}
