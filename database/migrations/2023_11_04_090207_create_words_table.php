<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->integer('word_number')->primary();
            $table->string('japanese', 20);
            $table->string('korean', 20);
            $table->string('korean_definition', 255);
            $table->string('tag', 20);
        });
    }

    public function down()
    {
        Schema::dropIfExists('words');
    }
};
