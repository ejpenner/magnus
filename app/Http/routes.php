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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/home', 'UserController@login');
    Route::get('/', 'UserController@login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UserController');

    Route::resource('permissions', 'PermissionController');
});

Route::resource('profile', 'ProfileController');

Route::resource('gallery', 'GalleryController');

Route::resource('profile.gallery.piece', 'PieceController');



// User Show
//Route::bind('user', function($value) {
//   return \App\User::where('name', '=', $value)->first();
//});



//Route::bind('profile', function($value) {
//    $userId = \App\User::where('username', '=', $value)->value('id');
//    $profile = \App\Profile::where('id', $userId)->first();
//
//    return view('profiles.show', compact($profile));
//});


Route::get('/home', 'HomeController@index');


Route::group(['middleware' => ['id']], function ($id) {
    Route::get('users/{id}/editAccount', 'UserController@editAccount');
    Route::patch('users/{id}/updateAccount', 'UserController@updateAccount');
    Route::get('users/{id}/account', array('uses' => 'UserController@manageAccount', 'as' => 'user.account'));
    Route::get('users/{id}/changeMyPassword', array('uses' => 'UserController@changeAccountPassword', 'as' => 'user.accountPassword'));
    Route::patch('users/{id}/updatePassword', 'UserController@updatePassword');
});
