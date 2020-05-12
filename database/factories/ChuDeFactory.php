<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ChuDe;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ChuDe::class, function (Faker $faker) {
    $ten = $faker->word;
    return [
        'ten' => $ten,
        'slug' => Str::slug($ten),
        'user_id' => function(){
            return User::all()->random();
        }
    ];
});
