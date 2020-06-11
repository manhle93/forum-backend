<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTinNhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tin_nhans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_gui_id')->nullable();
            $table->foreign('user_gui_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_nhan_id')->nullable();
            $table->foreign('user_nhan_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('noi_dung')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tin_nhans');
    }
}
