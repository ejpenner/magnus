<?php

namespace Magnus\Http\Controllers;

use Magnus\Opus;
use Magnus\Permission;
use Magnus\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function session(Request $request)
    {
        $session = $request->session()->all();
        return view('admin.session', compact('session'));
    }
    
    public function index()
    {
        return view('admin.index');
    }

    public function test()
    {
//        $files = File::glob(base_path('resources/seed-pics/*.*'));
//        dd($files[rand(1,10)]);
        //dd(public_path('art/Vilest'));
        //dd(strrpos(app('url')->previous(), 'opus'));
        //dd(app('url')->previous());
        //dd(Permission::hasPermission(Auth::user(), 'user_banned'));
        dd(Auth::user()->favorites);
        dd(Opus::find(32)->favorites);
        $favorite = $favorites = Auth::user()->favorites->where(['opus_id'=>32])->get();

        dd($favorite);
    }
}
