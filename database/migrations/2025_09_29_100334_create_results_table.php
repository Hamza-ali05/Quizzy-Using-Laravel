<?php

use Illuminate\Database\Migrations\Migration;//used for migrate and rollback
use Illuminate\Database\Schema\Blueprint;//used for creating tables and coloumns
use Illuminate\Support\Facades\Schema;//used for functions like create, up and down

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attempt_id');//foreign key
            $table->unsignedBigInteger('question_id');//forign key
            $table->unsignedBigInteger('option_id');//foreign key
            $table->boolean('correct')->default(false);//for true or false 

            //foreign key
            $table->foreign('attempt_id')->references('id')->on('attempts')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
