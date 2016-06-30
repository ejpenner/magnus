<?php

namespace Magnus\Http\Controllers;

use Illuminate\Http\Request;

use Magnus\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function session(Request $request) {
        $session = $request->session()->all();
        return view('admin.session', compact('session'));
    }
    
    public function center()
    {
        
    }

    public function test()
    {
        $files = File::glob(base_path('resources/seed-pics/*.*'));
        dd($files[rand(1,10)]);
    }
}
