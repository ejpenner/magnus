<?php

namespace App\Http\Middleware;

use Closure;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

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

        if (Auth::user()->atLeastHasRole(Config::get('roles.globalMod')) or Auth::user()or Auth::user()->isOwner($comment)) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
