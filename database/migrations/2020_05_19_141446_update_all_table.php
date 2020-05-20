<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chu_des', function (Blueprint $table) {
            $table->string('anh_dai_dien')->nullable();
            $table->dropColumn('slug');

        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('anh_dai_dien')->nullable();
        });
        Schema::table('bai_viets', function (Blueprint $table) {
            $table->string('anh_dai_dien')->nullable();
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
