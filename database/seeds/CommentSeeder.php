<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pieces = \App\Piece::all();
        $users = \App\User::count();

        foreach($pieces as $piece) {
            $piece->comments()->save(factory(\App\Comment::class)->make(['user_id'=>rand(1,$users)]));
        }

        $comments = \App\Comment::all();

        foreach($comments as $comment) {
            $comment->childComments()->save(factory(\App\Comment::class)->make(['user_id'=>rand(1,$users), 'piece_id'=>$comment->piece->id]));

            foreach ($comment->childComments() as $child) {
                $child->save(factory(\App\Comment::class)->make(['user_id'=>rand(1,$users), 'parent_id'=>$comment->id, 'piece_id'=>$comment->piece->id]));
            }
        }
    }
}
