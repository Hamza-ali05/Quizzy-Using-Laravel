<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('quizzes', function (Blueprint $table) {
        $table->integer('duration')->nullable()->comment('Duration in minutes');
    });
}

public function down()
{
    Schema::table('quizzes', function (Blueprint $table) {
        $table->dropColumn('duration');
    });
}

};
