<?php

namespace Magnus\Http\Middleware;

use Closure;
use Magnus\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class GalleryManagement
{
    /**
     *  Allow a user to continue with an operation on an Opus if they own it or are at least a global mod
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $gallery_id = $request->route('gallery');
        $gallery = Gallery::where('id', $gallery_id)->first();

        if (!Auth::check() or Auth::user()->atLeastHasRole(Config::get('roles.gmod-code')) or Auth::user()->isOwner($gallery)) {
            return $next($request);
        } else {
            return redirect()->back()->withErrors('You are not permitted to complete that action or view that page.');
        }
    }
}
