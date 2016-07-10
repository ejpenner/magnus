<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('schema_name');
            $table->integer('role_id')->unsigned();
            $table->string('role_code');

            // new fields for permission v2 below
            $table->boolean('user_opus_permission');
            $table->boolean('user_comment_permission');
            $table->boolean('user_gallery_permission');
            $table->boolean('user_profile_permission');
            $table->boolean('user_pm_permission');
            $table->boolean('user_banned');
            // power user permissions, can make, edit, delete things
            $table->boolean('admin_opus_permission');
            $table->boolean('admin_comment_permission');
            $table->boolean('admin_gallery_permission');
            $table->boolean('admin_profile_permission');
            $table->boolean('admin_pm_permission'); // allows role to see other people's PMs
            // admin center powers and access
            $table->boolean('admin_center_access');
            $table->boolean('admin_handle_reports');
            $table->boolean('admin_suspend_users');
            $table->boolean('admin_ban_users');
            $table->boolean('admin_make_admins');
            $table->boolean('admin_make_mods');
            $table->boolean('admin_make_devs');
            $table->boolean('admin_mass_delete');
            $table->boolean('admin_user_lookup');;
            $table->boolean('admin_mass_notify');;
            $table->boolean('admin_user_permission');
            $table->boolean('admin_role_permission');
            $table->boolean('admin_role_assign');
            $table->boolean('admin_dev_tools');
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