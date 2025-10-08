<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('attempts', function (Blueprint $table) {
        $table->integer('finished_at')->nullable()->comment('Duration in minutes');
    });
}

public function down()
{
    Schema::table('attempts', function (Blueprint $table) {
        $table->dropColumn('duration');
    });
}

};
