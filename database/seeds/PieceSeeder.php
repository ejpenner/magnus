<?php

use Illuminate\Database\Seeder;

use App\Piece;

class PieceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Piece::class, 10)->create()
        ->each(function($piece) {
            $piece->featured()->save(factory(\App\Feature::class)->make(['piece_id'=>$piece->id]));
        });

        //factory(\App\Feature::class, 50)->create();

    }
}
