<?php

use App\BaiViet;
use App\BinhLuan;
use App\ChuDe;
use App\Like;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create();
        factory(ChuDe::class, 8)->create();
        factory(BaiViet:: class, 30)->create();
        factory(BinhLuan::class, 60)->create()->each(function ($reply){
            return $reply->likes()->save(factory(Like::class)->make());
        });
    }
}
