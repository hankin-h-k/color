<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableUsersAddAvatar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->comment('头像')->after('name');
            $table->string('mobile')->unique()->comment('手机号')->after('name');
            $table->tinyInteger('is_admin')->default(0)->comment('是否是管理员0：否，1：是')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'mobile', 'is_admin']);
        });
    }
}
