<?php
use Illuminate\Support\Facades\Config;

/**
 * Model bindings
 */
Route::model('users', 'User');
Route::model('profile', 'Profile');

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
 * A pretty url to show opera that are in a gallery
 */
Route::get('/gallery/{gallery}/{opus}', 'OpusController@galleryShow');


/**
 * Gallery, opus, and comment CRUD resources
 */
Route::resource('gallery', 'GalleryController');
Route::resource('opus', 'OpusController');
//Route::resource('opus.comment', 'CommentController');
Route::get('opus/{opus}/comment/{comment}', 'CommentController@show');
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
    Route::get('/submit', 'OpusController@newSubmission')->name('');
    Route::post('/submit', 'OpusController@submit');

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
    Route::post('opus/{opus}/comment', 'CommentController@store');
    Route::patch('opus/{opus}/{comment}', 'CommentController@updateChild');
    Route::delete('opus/{opus}/comment/{comment}', 'CommentController@destroy');
    Route::delete('opus/{opus}/{comment}', 'CommentController@destroyChild');

    /**
     * Notification controller and related routes
     */
    Route::get('messages', 'NotificationController@index');
    Route::get('messages/{id}', 'NotificationController@destroy');
    Route::delete('messages/selected', 'NotificationController@destroySelected');
    Route::post('opus/{opus}/{comment}/{notification}', 'CommentController@storeChildRemoveNotification');


    /**
     * CRUD routes for user account operations
     * TODO: refactor id middleware
     */
    Route::group(['middleware' => ['account']], function () {
        Route::patch('account/{users}/update', 'AccountController@updateAccount')->name('account.update');
        Route::get('account/{users}', 'AccountController@manageAccount')->name('account.manage');
        Route::patch('account/{users}/updatePassword', 'AccountController@updatePassword')->name('password.update');
        Route::patch('account/{users}/preferences', 'AccountController@updatePreferences')->name('account.preferences.update');
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
    Route::group(['middleware'=>'permission:atLeast,'.Config::get('roles.dev-code'), 'prefix'=>'admin'], function () {
        Route::get('session', 'AdminController@session');
        Route::get('test', 'AdminController@test');
        Route::get('/', 'AdminController@index');
    });

    /**
     * Administration middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.Config::get('roles.admin-code')], function () {
        Route::resource('permissions', 'PermissionController');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');

    });

    /**
     * Global moderator middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.Config::get('roles.gmod-code')], function () {
        Route::get('user/{users}/avatar', 'UserController@avatarAdmin');
        Route::post('user/{users}/avatar', 'UserController@uploadAvatarAdmin');
    });
});

/**
 * Home route
 */
Route::get('/{filter?}/{period?}', 'HomeController@recent')->name('home');