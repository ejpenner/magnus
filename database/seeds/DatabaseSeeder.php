<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Model::unguard();
        
        $this->call(RoleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PreferenceSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(OpusSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(FavoriteSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(WatchSeeder::class);

        Model::reguard();
    }
}
