<?php

use Illuminate\Database\Seeder;
use Magnus\Opus;
use Magnus\User;
use Magnus\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pieces = Opus::all();
        $users = User::count();

        foreach($pieces as $piece) {
            $piece->comments()->save(factory(Comment::class)->make(['user_id'=>rand(1,$users)]));
        }

        $comments = Comment::all();

        foreach($comments as $comment) {
            $comment->childComments()->save(factory(Comment::class)->make(['user_id'=>rand(1,$users), 'opus_id'=>$comment->opus->id]));

            foreach ($comment->childComments() as $child) {
                $child->save(factory(Comment::class)->make(['user_id'=>rand(1,$users), 'parent_id'=>$comment->id, 'opus_id'=>$comment->opus->id]));
            }
        }
    }
}
