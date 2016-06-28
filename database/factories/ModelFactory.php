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

$factory->define(Magnus\User::class, function (Faker\Generator $faker) {
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
    File::makeDirectory(public_path('art/'.$user['username'].'/images'), 0755, true);
    File::makeDirectory(public_path('art/'.$user['username'].'/thumbnails'), 0755, true);
    File::makeDirectory(public_path('art/'.$user['username'].'/avatars'), 0755, true);
    return $user;
});

$factory->define(Magnus\Opus::class,  function (Faker\Generator $faker){
    $sizes = [0 => [250,160], 1 => [160,250]];
    $res = $sizes[rand(0,1)];
    $theme = '';
    $usersMax = \Magnus\User::count();
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

$factory->define(Magnus\Gallery::class, function (Faker\Generator $faker){
    return [
        'name' => ucwords($faker->words(3, true)),
        'description' => $faker->sentence,
        'main_gallery' => 0,
    ] ;
});

$factory->define(Magnus\Comment::class, function (Faker\Generator $faker){
   return [
       'body' => $faker->paragraph,
   ];
});

$factory->define(Magnus\Profile::class, function (Faker\Generator $faker){
    return [
        'biography' => $faker->paragraphs(2, true),
    ] ;
});

$factory->defineAs(Magnus\Notification::class, 'opus', function (Faker\Generator $faker){
    $opusCount = \Magnus\Opus::count();
    $randomOpus = rand(1,$opusCount);
    $noteStore = ['handle'=>'opus', 'opus_id'=>rand(1,$randomOpus), 'read'=>0];
    return $noteStore;
});

$factory->defineAs(Magnus\Notification::class, 'comment', function (Faker\Generator $faker){
    $commentCount = \Magnus\Comment::count();
    $randomComment = rand(1, $commentCount);
    $noteStore = ['handle'=>'comment', 'comment_id'=>rand(1,$randomComment), 'read'=>0];
    return $noteStore;
});

$factory->define(\Magnus\Tag::class, function (Faker\Generator $faker){
   return [
       'name' => $faker->unique()->word,
   ]; 
});

$factory->define(\Magnus\Watch::class, function(Faker\Generator $faker){
   return [
       'watch_comments' => true,
       'watch_opus'     => true,
       'watch_activity' => true
   ];
});

