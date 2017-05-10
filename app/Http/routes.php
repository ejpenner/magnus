<?php
use Illuminate\Support\Facades\Config;

/**
 * Model bindings
 */
//Route::model('users', 'User');
//Route::model('profile', 'Profile');
//Route::model('opus', 'Opus');
//Route::model('category', 'Category');
//Route::model('journal', 'Journal');

/**
 * Binds {opus} to the opus model slug
 */
Route::bind('opus', function ($value, $route) {
    return \Magnus\Opus::whereSlug(strtolower($value))->firstOrFail();
});

/**
 * Binds the {users} parameter to the slug
 */
Route::bind('users', function ($value, $route) {
    return \Magnus\User::whereSlug(strtolower($value))->firstOrFail();
});

/**
 *  binds User model via slug to {profile} variable
 */
Route::bind('profile', function ($value, $route) {
    return \Magnus\User::whereSlug(strtolower($value))->firstOrFail();
});

/**
 * Binds the Category model to the {category} variable
 */
Route::bind('category', function ($value, $route) {
    return \Magnus\Category::whereSlug(strtolower($value))->firstOrFail();
});

Route::bind('category2', function ($value, $route) {
    return \Magnus\Category::whereSlug(strtolower($value))->firstOrFail();
});

Route::bind('category3', function ($value, $route) {
    return \Magnus\Category::whereSlug(strtolower($value))->firstOrFail();
});

Route::bind('category4', function ($value, $route) {
    return \Magnus\Category::whereSlug(strtolower($value))->firstOrFail();
});

/**
 * Binds journal model to {journal}
 */
Route::bind('journal', function ($value, $route) {
    return \Magnus\Journal::whereSlug(strtolower($value))->firstOrFail();
});

/**
 * generated auth routes
 */
Route::auth();

/**
 * Error 401 Unauthorized Route
 */
Route::get('errors/401', ['as' => '401', function () {
    return view('errors.401');
}]);

/**
 * Route for browsing via categories
 */
Route::get('browse/{category}/{category2?}/{category3?}/{category4?}');

/**
 * A pretty url to show opera that are in a gallery
 */
Route::get('/gallery/{gallery}/{opus}', 'OpusController@galleryShow');

/**
 * Gallery, opus, and comment CRUD resources
 */
Route::resource('gallery', 'GalleryController');
Route::resource('opus', 'OpusController');
Route::get('opus/{opus}/favorites', 'FavoriteController@show')->name('favorites.show');
Route::get('comments/{comment}', 'CommentController@show')->name('comment.show');
Route::get('opus/{opus}/download', 'OpusController@download')->name('opus.download');

/**
 * Profile routes
 */
Route::get('profile', 'ProfileController@index')->name('profile.auth');
Route::get('profile/{profile}', 'ProfileController@show')->name('profile.show');
Route::get('profile/{profile}/favorites', 'ProfileController@favorites')->name('profile.favorites');
Route::get('profile/{profile}/galleries', 'ProfileController@galleries')->name('profile.galleries');
Route::get('profile/{profile}/opera', 'ProfileController@opera')->name('profile.opera');
Route::get('profile/{profile}/watchers', 'ProfileController@watchers')->name('profile.watchers');
Route::get('profile/{profile}/watching', 'ProfileController@watching')->name('profile.watching');
Route::get('profile/{profile}/journal', 'JournalController@index')->name('profile.journal.index');
Route::get('profile/{profile}/journal/{journal}', 'JournalController@show')->name('journal.show');

/**
 * Search route
 */
Route::get('/search/{terms}', ['uses'=> 'SearchController@searchAll', 'as'=>'searchAll'])->name('search');

/**
 * Authenticated middleware group
 */
Route::group(['middleware' => ['auth']], function () {
    /**
     * Alternate create and store routes for creating Opus
     */
    Route::get('/submit', 'OpusController@newSubmission')->name('submit');
    Route::post('/submit/new', 'OpusController@store')->name('opus.store');
    
    /**
     * Pretty url CRUD for comments
     */
    Route::post('comment/{opus}', 'CommentController@store');
    Route::post('comments/{comment}', 'CommentController@storeChild');
    Route::patch('comment/{comment}', 'CommentController@update');
    Route::delete('comment/{comment}', 'CommentController@destroy');
    Route::delete('comment/{comment}', 'CommentController@destroyChild');
    Route::post('journal/{journal}/comment', 'CommentController@storeJournal');
    Route::post('profile/{profile}/comment', 'CommentController@storeProfile');

    /**
     * Notification controller and related routes
     */
    Route::get('messages', 'NotificationController@index')->name('message.center');
    Route::get('messages/{id}', 'NotificationController@destroy')->name('message.destroy');
    Route::post('messages/{comment}/{notification}', 'CommentController@storeChildRemoveNotification');
    Route::delete('messages/selected', 'NotificationController@destroySelected');
    
    /**
     * Favorite routes
     */
    Route::post('opus/{opus}/add', 'FavoriteController@store')->name('favorites.add');
    Route::get('opus/{opus}/favorites', 'FavoriteController@show')->name('favorites.show');
    Route::delete('opus/{opus}/remove', 'FavoriteController@destroy')->name('favorites.remove');

    /**
     * CRUD routes for user account operations
     */
    Route::group(['middleware' => ['account']], function () {
        Route::patch('account/{users}/update', 'AccountController@updateAccount')->name('account.update');
        Route::get('account/{users}', 'AccountController@manageAccount')->name('account.manage');
        Route::patch('account/{users}/updatePassword', 'AccountController@updatePassword')->name('password.update');
        Route::patch('account/{users}/preferences', 'AccountController@updatePreferences')->name('account.preferences.update');
        Route::get('profile/{profile}/edit', 'ProfileController@edit')->name('profile.edit');
        Route::patch('profile', 'ProfileController@update')->name('profile.update');
        Route::post('account/{users}/avatar', 'AccountController@uploadAvatar')->name('account.avatar');
    });

    /**
     * Journal routes
     */
    Route::get('journal/new', 'JournalController@create')->name('journal.create');
    Route::post('journal/store', 'JournalController@store')->name('journal.store');
    Route::patch('journal/{journal}', 'JournalController@update')->name('journal.update');
    Route::delete('journal/{journal}', 'JournalController@delete')->name('journal.delete');

    /**
     *  User avatar routes
     */
    Route::get('users/avatar', 'UserController@avatar')->name('account.avatar');
    Route::post('users/avatar', 'UserController@uploadAvatar')->name('account.avatar.update');

    /**
     *  User watch routes
     */
    Route::post('users/{users}/watch', 'UserController@watchUser')->name('user.watch');
    Route::get('users/{users}/unwatch', 'UserController@unwatchUser')->name('user.unwatch');

    /**
     * Developer middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.config('roles.admin-code'), 'prefix'=>'admin'], function () {
        Route::get('session', 'AdminController@session')->name('admin.session');
        Route::get('test', 'AdminController@test')->name('admin.test');
        Route::get('opus', 'AdminController@opus')->name('admin.opus');
        Route::get('flush', 'AdminController@flushCache')->name('admin.flushCache');
        Route::resource('permissions', 'PermissionController');
        Route::resource('users', 'UserController');
        Route::resource('roles', 'RoleController');
        Route::resource('categories', 'CategoryController');
        Route::get('/', 'AdminController@index')->name('admin.index');
    });

    /**
     * Administration middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.config('roles.admin-code')], function () {

    });

    /**
     * Global moderator middleware group
     */
    Route::group(['middleware'=>'permission:atLeast,'.config('roles.gmod-code')], function () {
        Route::post('account/{users}/avatarAdmin', 'AccountController@uploadAvatarAdmin');
    });
});

/**
 * Home route
 */
Route::get('/{filter?}/{period?}', 'HomeController@home')->name('home');
