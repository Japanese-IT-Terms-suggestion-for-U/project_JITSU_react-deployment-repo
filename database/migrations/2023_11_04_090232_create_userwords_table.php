<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('userwords', function (Blueprint $table) {
            $table->integer('userword_id')->primary();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('word_number');
            $table->boolean('is_favorite');
            $table->boolean('is_memorized');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('word_number')->references('word_number')->on('words');
        });
    }

    public function down()
    {
        Schema::dropIfExists('userwords');
    }
};
