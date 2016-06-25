<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    $timezones = ['America/Denver', 'America/New_York', 'America/Chicago', 'America/Los_Angeles'];
        $user = [
        'name'      => $faker->name,
        'email'     => $faker->safeEmail,
        'username'  => $faker->userName,
        'password'  => bcrypt('password'),
        'slug'      => str_slug($faker->userName),
        'avatar'    => substr($faker->image($dir = public_path('avatars'), $width = 150, $height= 150), 38),
        'timezone'  => $timezones[rand(0,3)],
        'remember_token' => str_random(10),
    ];
    File::makeDirectory(public_path('usr/'.$user['username'].'/images'), 0755, true);
    File::makeDirectory(public_path('usr/'.$user['username'].'/thumbnails'), 0755, true);
    File::makeDirectory(public_path('usr/'.$user['username'].'/avatars'), 0755, true);
    return $user;
});

$factory->define(App\Opus::class,  function (Faker\Generator $faker){
    $sizes = [0 => [250,160], 1 => [160,250]];
    $res = $sizes[rand(0,1)];
    $theme = '';
    $usersMax = \App\User::count();
    $faker->seed(rand(11111,99999));
    $image_path = substr($faker->image($dir = public_path('images'), $width = 600, $height=400,$theme), 38);
    $thumbnail_path = substr($faker->image($dir = public_path('thumbnails'), $width = $res[0], $height=$res[1], $theme), 38);
    return [
        'title' => ucwords($faker->words(3, true)),
        'comment' => $faker->paragraphs(2,true),
        'image_path' => $image_path,
        'thumbnail_path' => $thumbnail_path,
        'published_at' => \Carbon\Carbon::now(),
        'views'        => rand(1000,3000),
        'daily_views'  => rand(100,1000), 
        //'user_id' => rand(1, $usersMax),
    ];
});

$factory->define(App\Gallery::class, function (Faker\Generator $faker){
    return [
        'name' => ucwords($faker->words(3, true)),
        'description' => $faker->sentence,
        'main_gallery' => 0,
    ] ;
});

$factory->define(App\Comment::class, function (Faker\Generator $faker){
   return [
       'body' => $faker->paragraph,
   ];
});

$factory->define(App\Profile::class, function (Faker\Generator $faker){
    return [
        'biography' => $faker->paragraphs(2, true),
    ] ;
});

$factory->defineAs(App\Notification::class, 'opus', function (Faker\Generator $faker){
    $opusCount = \App\Opus::count();
    $randomOpus = rand(1,$opusCount);
    $noteStore = ['handle'=>'opus', 'opus_id'=>rand(1,$randomOpus), 'read'=>0];
    return $noteStore;
});

$factory->defineAs(App\Notification::class, 'comment', function (Faker\Generator $faker){
    $commentCount = \App\Comment::count();
    $randomComment = rand(1, $commentCount);
    $noteStore = ['handle'=>'comment', 'comment_id'=>rand(1,$randomComment), 'read'=>0];
    return $noteStore;
});

$factory->define(\App\Tag::class, function (Faker\Generator $faker){
   return [
       'name' => $faker->unique()->word,
   ]; 
});

$factory->define(\App\Watch::class, function(Faker\Generator $faker){
   return [
       'watch_comments' => true,
       'watch_opus'     => true,
       'watch_activity' => true
   ];
});

