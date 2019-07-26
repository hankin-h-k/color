<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowPics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('show_pics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pic')->nullable()->comment('图片');
            $table->string('paht')->nullable()->comment('链接');
            $table->string('type')->nullable()->comment('类型');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('show_pics');
    }
}
