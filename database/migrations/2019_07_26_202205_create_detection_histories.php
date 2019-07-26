<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetectionHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detection_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('pic')->comment('检测图片');
            $table->integer('example_id')->nullable()->comment('病例id');
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
        Schema::dropIfExists('detection_histories');
    }
}
