<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SongRequest;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(SongRequest::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Youtube($faker));

    return [
        'name' => $faker->name,
        'youtube_link' => $faker->youtubeRandomUri(),
        'video_name' => $faker->words(3, true)
    ];
});
