<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu_name', 100);
            $table->string('menu_url');
            $table->integer('father_id')->comment('-1：根目录');
            $table->integer('sort')->default(0);
            $table->tinyInteger('display')->default(1)->comment('0：隐藏,1：显示');
            $table->tinyInteger('state')->default(1)->comment('1：后台,2：前台');
            $table->softDeletes();
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
        Schema::dropIfExists('menus');
    }
}
