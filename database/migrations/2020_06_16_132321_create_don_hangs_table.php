<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonHangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('san_pham_id')->nullable();
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
            $table->integer('user_mua_hang_id')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->integer('so_luong')->nullable();
            $table->double('tong_tien')->nullable();
            $table->string('ten_nguoi_mua')->nullable();
            $table->text('dia_chi')->nullable();
            $table->string('trang_thai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('don_hangs');
    }
}
