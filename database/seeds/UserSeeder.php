<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Gallery;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vilest = User::create(['name'=>'Eric', 'username'=>'Vilest', 'slug' => 'vilest', 'email'=>'epenner@unomaha.edu',
            'password'=>'$2y$10$2vC4FBlXEw9jAp2mHX/I1ereZawBmX.tipKbEIfMlQo1g6VytHkQa']);
        $vilest->roles()->attach(Role::where('role_name', 'Developer')->value('id'));
        $vilest->galleries()->save(new Gallery(['main_gallery'=>1, 'name'=>'Main Gallery']));
   

        factory(User::class,10)->create()
            ->each(function($user){

                $user->roles()->attach(Role::where('role_name', 'User')->value('id'));

                foreach(range(1,1) as $index) {
                    factory(\App\Opus::class, 2)->create(['user_id'=>$user->id])->each(function($opus) {
                        $tagCount = \App\Tag::count();

                        foreach(range(1,3) as $j){
                            $tag = \App\Tag::where('id', $this->UniqueRandomNumbersWithinRange(1,$tagCount,1))->first();
                            $opus->tags()->attach($tag->id);
                        }
                    });
                }
                foreach(range(1,1) as $index) {
                    $user->galleries()->save(factory(\App\Gallery::class)->make());
                }
                foreach($user->galleries as $gallery) {
                    foreach(range(1,2) as $i) {

                        $opus = factory(\App\Opus::class)->create(['user_id'=>$user->id]);

                        echo $opus."\n\n";;

                        $opus->save();
                        $gallery->opera()->attach($opus->id);

                        $tagCount = \App\Tag::count();

                        foreach(range(1,3) as $j){
                            $tag = \App\Tag::where('id', $this->UniqueRandomNumbersWithinRange(1,$tagCount,1))->first();
                            $opus->tags()->attach($tag->id);
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
