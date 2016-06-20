<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Profile;
use App\Gallery;
use App\Piece;
use App\Opus;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware(
            'auth',
            [
                'only' => ['create','store','edit','update','destroy']
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $galleries = Gallery::where('user_id', $user->id)->limit(4)->get();
        $opera = Opus::where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(8)->get();

        return view('profile.show', compact('profile', 'user', 'galleries', 'opera'));
    }

    /**
     * Return a list of users that watch $user
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function watchers(User $user)
    {
        $query = User::query();
        $query->join('user_watch', 'users.id', '=', 'user_watch.watcher_user_id');
        $query->where('user_watch.watched_user_id', $user->id);
        $query->orderBy('user_watch.created_at', 'desc');
        $watchers = $query->paginate(50);
        if($user->name != null) {
            return view('profile.watchers', compact('user', 'watchers'));
        } else {
            return abort(404);
        }
    }

    public function watching(User $user)
    {
        $query = User::query();
        $query->join('user_watch', 'users.id', '=', 'user_watch.watched_user_id');
        $query->where('user_watch.watcher_user_id', $user->id);
        $query->orderBy('user_watch.created_at', 'desc');
        $watchers = $query->paginate(50);
        if($user->name != null) {
            return view('profile.watching', compact('user', 'watchers'));
        } else {
            return abort(404);
        }
    }

    /**
     * Return all the galleries of a user
     *
     * @param User $user
     */
    public function galleries(User $user) {
        $galleries = Gallery::where('user_id', $user->id)->get();
    }

    /**
     * return all the opus of a user
     * 
     * @param User $user
     */
    public function opera(User $user) {
        $profile = Profile::where('user_id', $user->id)->first();
        $opera = Opus::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(24);
        return view('profile.opera', compact('user','profile','opera'));
    }


    /**
     * Return all the piece submissions for a user
     *
     * @param User $user
     */
    public function submissions(User $user) {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     *  Display the specified user's profile
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $profile = Profile::where('user_id', $user->id)->first();
        $galleries = Gallery::where('user_id', $user->id)->limit(4)->get();
        $opera = Opus::where('user_id', $user->id)->limit(8)->get();
        if($user->name != null) {
            return view('profile.show', compact('profile', 'user', 'galleries', 'opera'));
        } else {
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
