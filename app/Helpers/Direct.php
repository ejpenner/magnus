<?php

namespace Magnus\Helpers;

use Magnus\Comment;

class Direct
{
    /**
     * A helper method for redirecting users when they post a comment to an opus
     * @param $opus
     * @param $newComment
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function newComment($commentable, Comment $newComment)
    {
        $back = app('url')->previous();
        if (strpos($back, 'opus') !== false) {
            return redirect()->to(app('url')->previous() . '#cid:' . $newComment->id)->with('success', 'Message posted!');
        } elseif (strpos($back, 'journal') !== false) {
            return redirect()->to(app('url')->previous() . '#cid:' . $newComment->id)->with('success', 'Message posted!');
        } elseif (strpos($back, 'journal') === false and strpos($back, 'profile') !== false) {
            return redirect()->to(app('url')->previous() . '#cid:' . $newComment->id)->with('success', 'Message posted!');
        } else {
            return redirect()->route('opus.show', $commentable->slug)->with('success', 'Message posted!');
        }
    }

    public static function newJournalComment($journal, Comment $newComment)
    {
        $back = app('url')->previous();
        if (strpos($back, 'journal') !== false) {
            return redirect()->to(app('url')->previous() . '#cid:' . $newComment->id)->with('success', 'Message posted!');
        } else {
            return redirect()->route('journal.show', $journal->slug)->with('success', 'Message posted!');
        }
    }

    public static function newProfileComment($profile, Comment $newComment)
    {
        $back = app('url')->previous();
        if (strpos($back, 'journal') !== false) {
            return redirect()->to(app('url')->previous() . '#cid:' . $newComment->id)->with('success', 'Message posted!');
        } else {
            return redirect()->route('profile.show', $profile->slug)->with('success', 'Message posted!');
        }
    }

    public static function route($route, array $message = [])
    {
        $redirect = redirect()->route($route);
        if($message != emptyArray()) {
            return $redirect->with($message[0], $message[1]);
        } else {
            return $redirect;
        }
    }
}
