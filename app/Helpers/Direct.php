<?php

namespace Magnus\Helpers\Direct;

class Direct
{
    public static function newComment($opus, $newComment)
    {
        $back = app('url')->previous();
        if (strpos($back, 'opus') !== false) {
            return redirect()->to(app('url')->previous() . '#cid:' . $newComment->id)->with('success', 'Message posted!');
        } else {
            return redirect()->route('opus.show', $opus->slug)->with('success', 'Message posted!');
        }
    }
}
