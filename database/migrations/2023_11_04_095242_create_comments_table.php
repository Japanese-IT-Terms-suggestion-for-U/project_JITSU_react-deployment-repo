<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('comment_id');
            $table->integer('post_id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('content', 255)->nullable();

            $table->foreign('post_id')->references('post_id')->on('posts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
