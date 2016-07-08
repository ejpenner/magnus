<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Permission;
use Magnus\Http\Requests;
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
        dd(Permission::hasPermission(Auth::user(), 'user_gallery_destroy'));
    }
}
