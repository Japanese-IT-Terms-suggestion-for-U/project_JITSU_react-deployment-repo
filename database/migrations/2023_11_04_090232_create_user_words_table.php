<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_words', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('word_number')->unsigned();
            $table->boolean('is_favorite');
            $table->boolean('is_memorized');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('word_number')->references('id')->on('words');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_words');
    }
};
