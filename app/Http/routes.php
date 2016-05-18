<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::resource('users', 'UserController');

Route::resource('permissions', 'PermissionController');

Route::resource('profile', 'ProfileController');

// User Show
//Route::bind('user', function($value) {
//   return \App\User::where('name', '=', $value)->first();
//});

Route::resource('profile.gallery', 'GalleryController');

//Route::bind('profile', function($value) {
//    $userId = \App\User::where('username', '=', $value)->value('id');
//    $profile = \App\Profile::where('id', $userId)->first();
//
//    return view('profiles.show', compact($profile));
//});

Route::resource('profile.gallery.piece', 'PieceController');

Route::get('/home', 'HomeController@index');
