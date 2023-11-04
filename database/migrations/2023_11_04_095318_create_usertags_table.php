<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('usertags', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->integer('tag_id');

            $table->primary(['user_id', 'tag_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tag_id')->references('tag_id')->on('tags');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usertags');
    }
};
