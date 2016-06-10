<?php

namespace App\Http\Middleware;

use Closure;

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
        $user_id = Comment::where('id', $comment_id)->value('user_id');

        if (Auth::user()->hasRole('admin') or $user_id == Auth::user()->id) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
