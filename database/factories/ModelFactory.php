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
    return [
        'name'      => $faker->name,
        'email'     => $faker->safeEmail,
        'username'  => $faker->userName,
        'password'  => bcrypt('password'),
        'slug'      => str_slug($faker->userName),
        'avatar'    =>     substr($faker->image($dir = public_path('avatars'), $width = 100, $height= 100, 'people'), 38),
        'permission_id' => rand(1,3),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Piece::class,  function (Faker\Generator $faker){
    $usersMax = \App\User::count();
    $faker->seed(rand(11111,99999));
    $image_path = substr($faker->image($dir = public_path('images'), $width = 600, $height=400), 38);
    $thumbnail_path = substr($faker->image($dir = public_path('thumbnails'), $width = 300, $height=180), 38);
    return [
        'title' => ucwords($faker->words(3, true)),
        'comment' => $faker->paragraphs(2,true),
        'image_path' => $image_path,
        'thumbnail_path' => $thumbnail_path,
        'published_at' => \Carbon\Carbon::now(),
        'user_id' => rand(1, $usersMax),
    ];
});

$factory->define(App\Gallery::class, function (Faker\Generator $faker){
    return [
        'name' => ucwords($faker->words(3, true)),
        'description' => $faker->sentence,
    ] ;
});

$factory->define(App\Profile::class, function (Faker\Generator $faker){
    return [
        'biography' => $faker->paragraphs(2, true),
    ] ;
});

$factory->define(App\Feature::class, function (Faker\Generator $faker){
    $galleryMax = \App\Gallery::count();
    $pieceMax = \App\Piece::count();
   return [
        'gallery_id' => rand(1, $galleryMax),
        'piece_id' => rand(1, $pieceMax)
   ] ;
});

$factory->define(\App\Tag::class, function (Faker\Generator $faker){
   return [
       'name' => $faker->unique()->word,
   ]; 
});

