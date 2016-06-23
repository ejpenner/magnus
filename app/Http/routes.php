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

/**
 * Error 401 Unauthorized Route
 */
Route::get('errors/401', ['as' => '401', function() {
    return view('errors.401');
}]);

/**
 * Binds the {users} parameter to the slug
 */
Route::bind('users', function ($value, $route) {
    return \App\User::whereSlug(strtolower($value))->first();
});

/**
 *  binds User model via slug to {profile} wildcard
 */
Route::bind('profile', function ($value, $route) {
    return \App\User::whereSlug(strtolower($value))->first();
});


/**
 * A pretty url to show opera that are in a gallery
 */
Route::get('gallery/{gallery}/{opus}', 'OpusController@galleryShow');


/**
 * Gallery, opus, and comment CRUD resources
 */
Route::resource('gallery', 'GalleryController');
Route::resource('opus', 'OpusController');
Route::resource('opus.comment', 'CommentController');
Route::get('opus/{id}/download', 'OpusController@download');


/**
 * Profile routes
 */
Route::resource('profile', 'ProfileController');
Route::get('profile/{profile}/galleries', 'ProfileController@galleries');
Route::get('profile/{profile}/opera', 'ProfileController@opera');
Route::get('profile/{profile}/watchers', 'ProfileController@watchers');
Route::get('profile/{profile}/watching', 'ProfileController@watching');

/**
 * Search route
 */
Route::get('/search/{terms}', ['uses'=> 'SearchController@searchAll', 'as'=>'searchAll']);

/**
 * Authenticated middleware group
 */
Route::group(['middleware' => ['auth']], function () {
    /**
     * Alternate create and store routes for creating Opus
     */
    Route::get('/new/submit', 'OpusController@newSubmission');
    Route::post('/new/submit', 'OpusController@submit');

    /**
     * CRUD routes for opera in galleries
     */
    Route::post('gallery/{gallery}/',           'OpusController@galleryStore');
    Route::patch('gallery/{gallery}/{opus}',    'OpusController@galleryUpdate');
    Route::delete('gallery/{gallery}/{opus}',   'OpusController@galleryDestroy');

    /**
     * Pretty url CRUD for comments
     */
    Route::get('comments/{comment}', 'CommentController@show');
    Route::post('opus/{opus}/{comment}', 'CommentController@storeChild');
    Route::patch('opus/{opus}/{comment}', 'CommentController@updateChild');
    Route::delete('opus/{opus}/{comment}', 'CommentController@destroyChild');

    /**
     * Notification controller and related routes
     */
    Route::resource('messages', 'NotificationController');
    Route::post('opus/{opus}/{comment}/{notification}', 'CommentController@storeChildRemoveNotification');

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
     *  User watch routes
     */
    Route::post('users/{users}/watch', 'UserController@watchUser');
    Route::get('users/{users}/unwatch', 'UserController@unwatchUser');

    /**
     * Developer middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.Config::get('roles.developer').'', 'prefix'=>'admin'], function () {
        Route::get('session', 'AdminController@session');
    });

    /**
     * Administration middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.Config::get('roles.administrator').''], function () {
        Route::resource('permissions', 'PermissionController');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');

    });

    /**
     * Global moderator middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.Config::get('roles.globalMod').''], function () {
        Route::get('users/{id}/avatar', 'UserController@avatarAdmin');
        Route::post('users/{id}/avatar', 'UserController@uploadAvatarAdmin');
    });
});

/**
 * Home route
 */
Route::get('/{filter?}', 'HomeController@recent')->name('home');