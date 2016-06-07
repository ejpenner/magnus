<?php
$faker = Faker\Factory::create();

//$piece = factory(\App\Piece::class)->make();
//
//echo strpos($faker->image($dir = public_path('thumbnails'), $width = 475, $height=300, 'cats'), '/thumbnails/');
//echo "<br>";
//echo substr($faker->image($dir = public_path('images'), $width = 475, $height=300, 'cats'), 38). "<br><br><br><br><br>";

$piece = factory(\App\Piece::class, 1)->make();

dd($piece);