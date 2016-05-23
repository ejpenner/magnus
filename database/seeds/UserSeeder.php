<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'Eric Penner','email'=>'epenner@unomaha.edu','password'=>'$2y$10$2vC4FBlXEw9jAp2mHX/I1ereZawBmX.tipKbEIfMlQo1g6VytHkQa', 'permission_id'=>1]);
    }
}
