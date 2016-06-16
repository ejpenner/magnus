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
        $galleries = Gallery::where('user_id', $user->id)->paginate(12);
        $pieces = Piece::where('user_id', $user->id)->join('features', 'features.piece_id', '=', 'pieces.id')->paginate(12);

        return view('profile.show', compact('profile', 'user', 'galleries', 'pieces'));
    }

    /**
     * Return all the galleries of a user
     *
     * @param User $user
     */
    public function gallery(User $user) {
        $galleries = Gallery::where('user_id', $user->id)->get();
    }

    /**
     * return all the opus of a user
     * 
     * @param User $user
     */
    public function opera(User $user) {
        
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
        $galleries = Gallery::where('user_id', $user->id)->paginate(12);
        //$pieces = Piece::where('user_id', $user->id)->join('features', 'features.piece_id', '=', 'pieces.id')->paginate(12);
        $opera = Opus::where('user_id', $user->id)->paginate(8);
        
        return view('profile.show', compact('profile', 'user', 'galleries', 'opera'));
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

    /**
     *  Return the Auth'd users profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    
    public function user() {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        
        return view('profile.show', compact('profile', 'user'));
    }
}
