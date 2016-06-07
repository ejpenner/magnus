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
        
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(ProfileSeeder::class);
        //$this->call(GallerySeeder::class);
        //$this->call(PieceSeeder::class);


        Model::reguard();
    }
}
