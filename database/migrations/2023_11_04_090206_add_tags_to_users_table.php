<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tag1', 20)->after('password')->nullable();
            $table->string('tag2', 20)->after('tag1')->nullable();
            $table->string('tag3', 20)->after('tag2')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tag1');
            $table->dropColumn('tag2');
            $table->dropColumn('tag3');
        });
    }
};
