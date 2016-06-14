<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\User;
use App\Permission;
use App\Role;
use App\Piece;

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

        $vilest = User::create(['name'=>'Eric Penner', 'username'=>'Vilest', 'slug' => 'vilest', 'email'=>'epenner@unomaha.edu',
            'password'=>'$2y$10$2vC4FBlXEw9jAp2mHX/I1ereZawBmX.tipKbEIfMlQo1g6VytHkQa']);
        $vilest->roles()->attach(Role::where('role_name', 'Developer')->value('id'));
   

        factory(User::class,10)->create()
            ->each(function($user){

                $user->roles()->attach(Role::where('role_name', 'User')->value('id'));
                
                foreach(range(1,1) as $index) {
                    $user->galleries()->save(factory(\App\Gallery::class)->make());
                }
                foreach($user->galleries as $gallery) {
                    foreach(range(1,1) as $i) {

                        $piece = factory(\App\Piece::class)->create(['user_id'=>$user->id]);

                        echo $piece."\n\n";;

                        $gallery->featured()->save(factory(\App\Feature::class)->make(['piece_id'=>$piece->id]));
                        $tagCount = \App\Tag::count();

                        foreach(range(1,1) as $j){
                            $tag = \App\Tag::where('id', $this->UniqueRandomNumbersWithinRange(1,$tagCount,1))->first();
                            $piece->tags()->attach($tag->id);
                            echo $tag."\n\n";;
                        }
                    }
                }
            });
    }

    private function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}
