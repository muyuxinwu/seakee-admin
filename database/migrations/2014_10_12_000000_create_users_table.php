<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->string('nick_name');
            $table->string('avatar');
            $table->string('email')->unique();
            $table->string('phone', 11)->unique();
            $table->tinyInteger('status')->default(1)->comment('0：禁用,1：启用');
            $table->tinyInteger('rank')->default(1)->comment('1：管理员,2：普通用户');
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
