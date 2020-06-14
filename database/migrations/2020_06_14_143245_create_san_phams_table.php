<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanPhamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('ten_san_pham')->nullable();
            $table->double('gia_ban')->nullable();
            $table->double('gia_nhap')->nullable();
            $table->text('mo_ta')->nullable();
            $table->text('anh_dai_dien')->nullable();
            $table->json('album_anh')->nullable();
            $table->integer('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('san_phams');
    }
}
