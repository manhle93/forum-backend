<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BaiViet;
use App\ChuDe;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(BaiViet::class, function (Faker $faker) {
    $tieu_de = $faker->sentence();
    return [
        'tieu_de' => $tieu_de,
        'slug' => Str::slug($tieu_de),
        'noi_dung' => $faker->text(),
        'chu_de_id' => function () {
            return ChuDe::all()->random();
        },
        'user_id' => function () {
            return User::all()->random();
        }
    ];
});
