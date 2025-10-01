<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('user_answers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('member_id');
        $table->unsignedBigInteger('quiz_id');
        $table->unsignedBigInteger('question_id');
        $table->unsignedBigInteger('option_id');
        $table->unsignedBigInteger('attempt_id')->nullable(); // link to attempts
        $table->timestamps();

        $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        $table->foreign('attempt_id')->references('id')->on('attempts')->onDelete('cascade');
    });
}

};
