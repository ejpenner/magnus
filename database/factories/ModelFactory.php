<?php
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Magnus\Helpers\Helpers;
use Carbon\Carbon;
use Magnus\Opus;
use Magnus\User;

$factory->define(Magnus\User::class, function (Faker\Generator $faker) {
    $timezones = ['America/Denver', 'America/New_York', 'America/Chicago', 'America/Los_Angeles'];
    $user = [
        'name'              => $faker->name,
        'email'             => $faker->safeEmail,
        'username'          => $faker->userName,
        'password'          => bcrypt('password'),
        'slug'              => str_slug($faker->userName),
        'avatar'            => '', //substr($faker->image($dir = public_path('avatars'), $width = 150, $height= 150), 38),
        'timezone'          => $timezones[rand(0,3)],
        'remember_token'    => str_random(10),
    ];
    Helpers::makeDirectories($user['username']);
    return $user;
});

$factory->define(Magnus\Opus::class,  function (Faker\Generator $faker){

    if(env('SEED_IMAGE_SOURCE', 'base') != 'heroku') {
        $files = File::glob(base_path('resources/seed-pics/*.*'));
    } else {
        $files = File::glob(base_path('resources/heroku-deploy-seed-pics/*.*'));
    }

    $rand = rand(0, count($files)-1);
    $numbers = substr(microtime(), 2, 8);

    try {
        $src = $files[$rand];
        $dest = public_path().'/images/'.preg_replace('/\s/', '_', basename($files[$rand]));
        $tdest = public_path().'/thumbnails/'.$numbers.preg_replace('/\s/', '_', basename($files[$rand]));
        $pdest = public_path().'/previews/'.$numbers.preg_replace('/\s/', '_', basename($files[$rand]));

        copy($src, $dest);
        $preview = resize($dest, 680);
        $preview->save($pdest);
        $thumbnail = resize($dest);
        $thumbnail->save($tdest);
    } catch (\Exception $e) {
        $rand = rand(0, count($files)-1);
        $src = $files[$rand];
        $dest = public_path().'/images/'.preg_replace('/\s/', '_', basename($files[$rand]));
        $tdest = public_path().'/thumbnails/'.$numbers.preg_replace('/\s/', '_', basename($files[$rand]));
        $pdest = public_path().'/previews/'.$numbers.preg_replace('/\s/', '_', basename($files[$rand]));

        copy($src, $dest);
        $preview = resize($src, 680);
        $preview->save($pdest);
        $thumbnail = resize($dest);
        $thumbnail->save($tdest);
    }

    $c9PathLength = 30;
    $myPathLength = 38;
    
    $image_path = substr($dest, $myPathLength);
    $thumbnail_path = substr($tdest, $myPathLength);
    $preview_path = substr($pdest, $myPathLength);

    $created = Carbon::instance($faker->dateTimeBetween('-2 months', 'now'));
        $title = $faker->words(3, true);
    return [
        'title'             => ucwords($title),
        'comment'           => $faker->paragraphs(2,true),
        'slug'              => substr(microtime(), 2,8).'-'.str_slug($title),
        'image_path'        => $image_path,
        'thumbnail_path'    => $thumbnail_path,
        'preview_path'      => $preview_path,
        'published_at'      => $created,
        'created_at'        => $created,
        'views'             => rand(1000,3000),
        'daily_views'       => rand(100,1000),
    ];
});

$factory->define(Magnus\Gallery::class, function (Faker\Generator $faker){
    return [
        'name'          => ucwords($faker->words(3, true)),
        'description'   => $faker->sentence,
        'main_gallery'  => 0,
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
    ];
});

$factory->defineAs(Magnus\Notification::class, 'opus', function (Faker\Generator $faker){
    $opusCount = \Magnus\Opus::count();
    $randomOpus = rand(1,$opusCount);
    $noteStore = [
        'handle'    => 'opus',
        'opus_id'   => rand(1,$randomOpus)
    ];
    return $noteStore;
});

$factory->defineAs(Magnus\Notification::class, 'comment', function (Faker\Generator $faker){
    $commentCount = \Magnus\Comment::count();
    $randomComment = rand(1, $commentCount);
    $noteStore = ['handle'=>'comment', 'comment_id'=>rand(1,$randomComment)];
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

$factory->define(\Magnus\Preference::class, function(Faker\Generator $faker) {
    $show = ['full','half','none'];
    $dob = \Magnus\Preference::makeDOB(rand(0,28), $faker->month, $faker->year);
    return [
        'sex' => rand(0,1) ? 'male' : 'female',
        'date_of_birth' => $dob,
        'show_sex' => rand(0,1),
        'show_dob' => $show[rand(0,2)],
        'per_page' => 24
    ];
});

//$factory->define(\Magnus\Favorite::class, function (){
//   $opus_total = Opus::count();
//    $user_count = User::count();
//
//});

/**
 * Resize the opus' image for it's thumbnail
 *
 * @param $image
 * @return Image
 */
function resize($image, $size = 250)
{
    $resize = Image::make($image);

    $ratio = $resize->width() / $resize->height();

    if($ratio > 1){ // image is wider than tall
        $resize->resize(isset($size) ? $size : $this->resizeTo, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    } else { // image is taller than wide
        $resize->resize(null, isset($size) ? $size : $this->resizeTo, function ($constraint) {
            $constraint->aspectRatio();
        });
    }
    return $resize;
}


