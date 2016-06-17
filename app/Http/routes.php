<?php
use Illuminate\Support\Facades\Config;

/**
 * Model bindings
 */
Route::model('users', 'User');
Route::model('profile', 'Profile');

/**
 * generated auth routes
 */
Route::auth();

Route::get('/', 'HomeController@recent')->name('home');

Route::get('errors/401', ['as' => '401', function() {
    return view('errors.401');
}]);

/**
 * Binds the {users} parameter to the slug
 */
Route::bind('users', function ($value, $route) {
    return \App\User::whereSlug(strtolower($value))->first();
});

Route::bind('profile', function ($value, $route) {
    return \App\User::whereSlug(strtolower($value))->first();
});

/**
 * Gallery, opus, and comment CRUD resources
 */
Route::resource('gallery', 'GalleryController');
Route::resource('opus', 'OpusController');
Route::resource('opus.comment', 'CommentController');

/**
 * A pretty url to show opera that are in a gallery
 */
Route::get('gallery/{gallery}/{opus}',      'OpusController@galleryShow');

/**
 * Authenticated middleware group
 */
Route::group(['middleware' => ['auth']], function () {

    /**
     * CRUD routes for opera in galleries
     */
    Route::post('gallery/{gallery}/',           'OpusController@galleryStore');
    Route::patch('gallery/{gallery}/{opus}',    'OpusController@galleryUpdate');
    Route::delete('gallery/{gallery}/{opus}',   'OpusController@galleryDestroy');

    /**
     * Pretty url CRUD for comments
     */
    Route::post('opus/{opus}/{comment}', 'CommentController@storeChild');
    Route::patch('opus/{opus}/{comment}', 'CommentController@updateChild');
    Route::delete('opus/{opus}/{comment}', 'CommentController@destroyChild');

    /**
     * Notification controller
     */
    Route::resource('messages', 'NotificationController');

    /**
     * CRUD routes for user operations
     * TODO: refactor id middleware
     */
    Route::group(['middleware' => ['id']], function ($id) {
        Route::get('users/{id}/editAccount', 'UserController@editAccount');
        Route::patch('users/{id}/updateAccount', 'UserController@updateAccount');
        Route::get('users/{id}/account', array('uses' => 'UserController@manageAccount', 'as' => 'user.account'));
        Route::get('users/{id}/changeMyPassword', array('uses' => 'UserController@changeAccountPassword', 'as' => 'user.accountPassword'));
        Route::patch('users/{id}/updatePassword', 'UserController@updatePassword');
    });

    /**
     *  User avatar routes
     */
    Route::get('users/avatar', 'UserController@avatar');
    Route::post('users/avatar', 'UserController@uploadAvatar');

    /**
     * Developer middleware group
     */
    Route::group(['middleware'=>'permission:role,'.Config::get('roles.developer').'', 'prefix'=>'admin'], function () {
        Route::get('session', 'AdminController@session');
    });

    /**
     * Administration middleware group
     */
    Route::group(['middleware'=>'permission:role,'.Config::get('roles.administrator').''], function () {
        Route::resource('permissions', 'PermissionController');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');

    });

    /**
     * Global moderator middleware group
     */
    Route::group(['middleware'=>'permission:role,'.Config::get('roles.globalMod').''], function () {
        Route::get('users/{id}/avatar', 'UserController@avatarAdmin');
        Route::post('users/{id}/avatar', 'UserController@uploadAvatarAdmin');
    });

//    Route::post('opus/{opus}/c/{c}', 'CommentController@storeChild');
//    Route::patch('opus/{opus}/c/{c}', 'CommentController@updateChild');
//    Route::delete('opus/{opus}/c/{c}', 'CommentController@destroyChild');

    Route::get('/submit', 'OpusController@newSubmission');
    Route::post('/submit', 'OpusController@submit');

});

Route::resource('profile', 'ProfileController');
Route::get('profile/{profile}/galleries', 'ProfileController@galleries');
Route::get('profile/{profile}/opera', 'ProfileController@opera');




Route::get('/home', 'HomeController@index');
//Route::get('/recent', ['uses'=> 'HomeController@recent', 'as'=>'recent']);
Route::get('/search/{terms}', ['uses'=> 'SearchController@searchAll', 'as'=>'searchAll']);
