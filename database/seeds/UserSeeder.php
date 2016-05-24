<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $permissionCount = Permission::all()->count();

        User::create(['name'=>'Eric Penner', 'username'=>'Vilest', 'slug' => 'vilest', 'email'=>'epenner@unomaha.edu',
            'password'=>'$2y$10$2vC4FBlXEw9jAp2mHX/I1ereZawBmX.tipKbEIfMlQo1g6VytHkQa', 'permission_id'=>1]);

        foreach(range(1,15) as $index) {
            User::create(['name'=>$faker->name, 'username'=>$faker->userName, 'slug' => str_slug($faker->userName, '-'),
                'email' => $faker->email, 'password' => bcrypt("password"), 'permission_id' => rand(1, $permissionCount)]);
        }
    }
}
