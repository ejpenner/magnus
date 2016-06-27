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
    return \Magnus\User::whereSlug(strtolower($value))->first();
});

/**
 *  binds User model via slug to {profile} wildcard
 */
Route::bind('profile', function ($value, $route) {
    return \Magnus\User::whereSlug(strtolower($value))->first();
});


/**
 * A pretty url to show opera that are in a gallery
 */
Route::get('galleria/{gallery}/{opus}', 'OpusController@galleryShow');


/**
 * Gallery, opus, and comment CRUD resources
 */
Route::resource('galleria', 'GalleryController');
Route::resource('opus', 'OpusController');
Route::resource('opus.comment', 'CommentController');
Route::get('opus/{id}/download', 'OpusController@download');


/**
 * Profile routes
 */
Route::resource('profile', 'ProfileController');
Route::get('profile/{profile}/galleria', 'ProfileController@galleries');
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
    Route::get('/nova/submit', 'OpusController@newSubmission');
    Route::post('/nova/submit', 'OpusController@submit');

    /**
     * CRUD routes for opera in galleries
     */
    Route::post('galleria/{gallery}/',           'OpusController@galleryStore');
    Route::patch('galleria/{gallery}/{opus}',    'OpusController@galleryUpdate');
    Route::delete('galleria/{gallery}/{opus}',   'OpusController@galleryDestroy');

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
        Route::get('user/{users}/editAccount', 'UserController@editAccount');
        Route::patch('user/{users}/updateAccount', 'UserController@updateAccount');
        Route::get('user/{users}/account', ['uses' => 'UserController@manageAccount', 'as' => 'user.account']);
        Route::get('user/{users}/changeMyPassword', array('uses' => 'UserController@changeAccountPassword', 'as' => 'user.accountPassword'));
        Route::patch('user/{users}/updatePassword', 'UserController@updatePassword');
        Route::get('user/{users}/preferences', 'UserController@preferences');
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
        Route::get('user/{users}/avatar', 'UserController@avatarAdmin');
        Route::post('user/{users}/avatar', 'UserController@uploadAvatarAdmin');
    });
});

/**
 * Home route
 */
Route::get('/{filter?}', 'HomeController@recent')->name('home');