<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BaiViet;
use App\BinhLuan;
use App\User;
use Faker\Generator as Faker;

$factory->define(BinhLuan::class, function (Faker $faker) {
    return [
        'noi_dung'=> $faker->sentence(),
        'user_id'=> function(){
            return User::all()->random();
        },
        'bai_viet_id' => function(){
            return BaiViet::all()->random();
        } 
    ];
});
