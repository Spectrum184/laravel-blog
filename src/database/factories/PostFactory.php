<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'category_id' => random_int(1, 8),
        'title' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'slug' => Str::slug($faker->sentence($nbWords = 5, $variableNbWords = true)),
        'image' => 'default.jpg',
        'body' => $faker->paragraph($nbWords = 20, $variableNbWords = true), // password
        'view_count' => random_int(10, 100),
        'status' => 1,
    ];
});
