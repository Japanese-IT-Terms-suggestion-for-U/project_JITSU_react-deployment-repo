<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->integer('post_id')->primary();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
