<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBaiVietChuDeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chu_des', function (Blueprint $table) {
            $table->text('mo_ta')->nullable();

        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('quyen_id')->nullable();
        });
        Schema::table('bai_viets', function (Blueprint $table) {
            $table->string('loai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
