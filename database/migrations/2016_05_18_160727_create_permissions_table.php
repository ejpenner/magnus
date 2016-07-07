<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('schema_name');
            $table->integer('role_id')->unsigned();

            // old permissions fields
            $table->boolean('create');
            $table->boolean('read');
            $table->boolean('edit');
            $table->boolean('destroy');
            $table->boolean('create_all');
            $table->boolean('read_all');
            $table->boolean('edit_all');
            $table->boolean('destroy_all');
            $table->boolean('gallery_all');
            $table->boolean('piece_all');
            $table->boolean('comment_all');
            $table->boolean('private_message_all');
            $table->boolean('private_message_access');
            $table->boolean('banned');

            // new fields for permission v2 below
            $table->boolean('user_opus_create');
            $table->boolean('user_opus_edit');
            $table->boolean('user_opus_destroy');
            $table->boolean('user_comment_create');
            $table->boolean('user_comment_edit');
            $table->boolean('user_comment_destroy');
            $table->boolean('user_gallery_create');
            $table->boolean('user_gallery_edit');
            $table->boolean('user_gallery_destroy');
            $table->boolean('user_profile_edit');
            $table->boolean('user_private_messages');
            $table->boolean('user_banned');
            // power user permissions, can make, edit, delete things
            $table->boolean('admin_opus_create');
            $table->boolean('admin_opus_edit');
            $table->boolean('admin_opus_destroy');
            $table->boolean('admin_comment_create');
            $table->boolean('admin_comment_edit');
            $table->boolean('admin_comment_destroy');
            $table->boolean('admin_gallery_create');
            $table->boolean('admin_gallery_edit');
            $table->boolean('admin_gallery_destroy');
            $table->boolean('admin_profile_edit');
            $table->boolean('admin_private_messages'); // allows role to see other people's PMs
            // admin center powers and access
            $table->boolean('admin_center_access');
            $table->boolean('admin_view_reports');
            $table->boolean('admin_penalize_users');
            $table->boolean('admin_close_reports');
            $table->boolean('admin_suspend_users');
            $table->boolean('admin_ban_users');
            $table->boolean('admin_make_admins');
            $table->boolean('admin_make_mods');
            $table->boolean('admin_make_devs');
            $table->boolean('admin_mass_delete');
            $table->boolean('admin_user_lookup');
            $table->boolean('admin_user_action');
            $table->timestamps();
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
