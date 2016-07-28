<?php

use Magnus\Opus;
use Magnus\User;
use Magnus\Comment;
use Magnus\Journal;
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
        $pieces = Opus::all();
        $users = User::count();
        $journals = Journal::all();

        foreach($pieces as $piece) {
            $piece->comments()->save(factory(Comment::class)->make(['user_id'=>rand(1,$users)]));
        }

        foreach($journals as $journal) {
            $journal->comments()->save(factory(Comment::class)->make(['user_id'=>rand(1,$users)]));
        }

        $comments = Comment::all();

        foreach($comments as $comment) {
            $comment->childComments()->save(factory(Comment::class)->make(['user_id'=>rand(1,$users)]));

            foreach ($comment->childComments() as $child) {
                $child->save(factory(Comment::class)->make(['user_id'=>rand(1,$users), 'parent_id'=>$comment->id]));
            }
        }

    }
}
