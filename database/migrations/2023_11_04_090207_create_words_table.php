<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->text('japanese');
            $table->text('korean');
            $table->text('korean_definition')->nullable();
            $table->bigInteger('tag_id')->unsigned()->nullable();

            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    public function down()
    {
        Schema::dropIfExists('words');
    }
};
