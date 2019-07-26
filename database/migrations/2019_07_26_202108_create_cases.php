<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examples', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->comment('名称');
            $table->string('color_value')->nullable()->comment('色值');
            $table->string('pic')->nullable()->comment('对比图');
            $table->string('type')->nullable()->comment('类型');
            $table->text('intro')->nullable()->comment('介绍');
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
        Schema::dropIfExists('examples');
    }
}
