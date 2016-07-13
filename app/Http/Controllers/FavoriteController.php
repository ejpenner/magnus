<?php

namespace Magnus\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Magnus\Http\Requests;
use Magnus\Notification;
use Magnus\Favorite;
use Magnus\Opus;
use Magnus\User;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Opus $opus)
    {
        $favorite = Favorite::firstOrCreate(['opus_id' => $opus->id]);
        if ($favorite->add($request->user())) {
            Notification::notifyCreatorNewFavorite($favorite);
            return redirect()->back()->with('success', 'Added to favorites!');
        } else {
            return redirect()->back()->with('message', 'You can\'t favorite your own work!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy(Request $request, Opus $opus)
    {
        $favorite = Favorite::findOrFail(['opus_id' => $opus->id])->first();
        if ($favorite->remove($request->user())) {
            return redirect()->back()->with('success', 'Removed from favorites');
        } else {
            return redirect()->back()->with('message', 'You can\'t unfavorite your own work!');
        }
    }
}
