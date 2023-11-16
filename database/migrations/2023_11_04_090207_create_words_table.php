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
            $table->string('tag', 20);
        });
    }

    public function down()
    {
        Schema::dropIfExists('words');
    }
};
