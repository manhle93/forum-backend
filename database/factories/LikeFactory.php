<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BinhLuan;
use App\Like;
use Faker\Generator as Faker;
use App\User;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return User::all()->random();
        },
        'reference_id' => function(){
            return BinhLuan::all()->random();
        },
        'type' => 'binh_luan'
    ];
});
