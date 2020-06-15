<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinhLuanSanPhamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binh_luan_san_phams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('noi_dung');
            $table->integer('user_id')->unsigned();
            $table->integer('san_pham_id')->unsigned();
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binh_luan_san_phams');
    }
}
