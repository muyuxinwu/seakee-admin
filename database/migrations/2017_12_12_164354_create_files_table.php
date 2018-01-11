<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('name', 100);
	        $table->string('type', 80);
	        $table->string('path', 200);
	        $table->string('disk', 20);
	        $table->string('size', 20);
	        $table->string('md5', 32);
	        $table->integer('uploader');
	        $table->tinyInteger('is_del')->default(0);
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
        Schema::dropIfExists('files');
    }
}
