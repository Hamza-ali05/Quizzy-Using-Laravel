<?php

use Illuminate\Database\Migrations\Migration;//used migrate and rollback functions
use Illuminate\Database\Schema\Blueprint;//used for creating tables and coloumns
use Illuminate\Support\Facades\Schema;//used for functions like create, up, down

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table)//used for creating tables and coloumns
        {
            $table->id();//unique id
            $table->unsignedBigInteger('quiz_id');//used as foreign id
            $table->text('questions_text');
            $table->timestamps();

            //foreign key
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
