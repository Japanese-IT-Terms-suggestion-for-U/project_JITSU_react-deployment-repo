<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->integer('tag_id')->primary();
            $table->string('tag_name', 20);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tags');
    }
};
