<?php

use Illuminate\Database\Migrations\Migration; // used for migrate and roll back
use Illuminate\Database\Schema\Blueprint; // used for creating tables and columns respectively
use Illuminate\Support\Facades\Schema; // used for creating functions like create, up and down

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();//primary key
            $table->string('title', 150); 
            $table->unsignedBigInteger('created_by'); // used as foreign key
            $table->string('description', 200)->nullable(); 
            $table->timestamps();


            // foreign key
            $table->foreign('created_by')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
