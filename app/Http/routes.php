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

Route::model('users', 'User');
Route::model('profile', 'Profile');

Route::auth();

Route::get('/', 'HomeController@recent')->name('home');

Route::get('errors/401', ['as' => '401', function() {
    return view('errors.401');
}]);

Route::bind('users', function ($value, $route) {
    return \App\User::whereSlug(strtolower($value))->first();
});

Route::bind('profile', function ($value, $route) {
    return \App\User::whereSlug(strtolower($value))->first();
});

Route::resource('gallery', 'GalleryController');
Route::resource('opus', 'OpusController');
Route::resource('opus.comment', 'CommentController');

// opus routes for opera inside a gallery
Route::get('gallery/{gallery}/{opus}',      'OpusController@galleryShow');


Route::group(['middleware' => ['auth']], function () {

    Route::post('gallery/{gallery}/',           'OpusController@galleryStore');
    Route::patch('gallery/{gallery}/{opus}',    'OpusController@galleryUpdate');
    Route::delete('gallery/{gallery}/{opus}',   'OpusController@galleryDestroy');

    Route::post('opus/{opus}/{comment}', 'CommentController@storeChild');
    Route::patch('opus/{opus}/{comment}', 'CommentController@updateChild');
    Route::delete('opus/{opus}/{comment}', 'CommentController@destroyChild');

    //Notifications
    Route::resource('messages', 'NotificationController');

    Route::group(['middleware' => ['id']], function ($id) {
        Route::get('users/{id}/editAccount', 'UserController@editAccount');
        Route::patch('users/{id}/updateAccount', 'UserController@updateAccount');
        Route::get('users/{id}/account', array('uses' => 'UserController@manageAccount', 'as' => 'user.account'));
        Route::get('users/{id}/changeMyPassword', array('uses' => 'UserController@changeAccountPassword', 'as' => 'user.accountPassword'));
        Route::patch('users/{id}/updatePassword', 'UserController@updatePassword');
    });

    Route::get('users/avatar', 'UserController@avatar');
    Route::post('users/avatar', 'UserController@uploadAvatar');
    
    Route::group(['middleware'=>'permission:role,Developer', 'prefix'=>'admin'], function () {
        Route::get('session', 'AdminController@session');
    });
    
    Route::group(['middleware'=>'permission:role,Administrator'], function () {
        Route::resource('permissions', 'PermissionController');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');

    });

    Route::group(['middleware'=>'permission:role,Global Moderator'], function () {
        Route::get('users/{id}/avatar', 'UserController@avatarAdmin');
        Route::post('users/{id}/avatar', 'UserController@uploadAvatarAdmin');
    });

    Route::post('opus/{opus}/c/{c}', 'CommentController@storeChild');
    Route::patch('opus/{opus}/c/{c}', 'CommentController@updateChild');
    Route::delete('opus/{opus}/c/{c}', 'CommentController@destroyChild');

    Route::get('/submit', 'PieceController@newSubmission');
    Route::post('/submit', 'PieceController@submit');

});

Route::resource('profile', 'ProfileController');
Route::get('profile/{profile}/galleries', 'ProfileController@galleries');
Route::get('profile/{profile}/opera', 'ProfileController@opera');




Route::get('/home', 'HomeController@index');
//Route::get('/recent', ['uses'=> 'HomeController@recent', 'as'=>'recent']);
Route::get('/search/{terms}', ['uses'=> 'SearchController@searchAll', 'as'=>'searchAll']);
