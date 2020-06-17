<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThongBaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thong_baos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type')->nullable();
            $table->boolean('da_doc')->default(false);
            $table->integer('reference_id')->nullable();
            $table->integer('user_id_nhan_thong_bao')->nullable();
            $table->foreign('user_id_nhan_thong_bao')->references('id')->on('users')->onDelete('cascade');
            $table->text('noi_dung')->nullable();
            $table->integer('user_id_tuong_tac')->nullable();
            $table->foreign('user_id_tuong_tac')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thong_baos');
    }
}
