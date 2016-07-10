<?php

namespace Magnus\Http\Middleware;

use Closure;
use Magnus\Comment;
use Magnus\Helpers\Helpers;

class CommentManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $comment_id = $request->route('c');
        $comment= Comment::where('id', $comment_id)->first();

        if (Helpers::isOwnerOrHasRole($comment, config('roles.moderator'))) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
