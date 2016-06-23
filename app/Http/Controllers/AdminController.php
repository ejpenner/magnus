<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function session(Request $request) {
        $session = $request->session()->all();
        return view('admin.session', compact('session'));
    }
    
    public function center()
    {
        
    }
}
