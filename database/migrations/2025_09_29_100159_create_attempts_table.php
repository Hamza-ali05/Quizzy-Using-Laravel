<?php

use Illuminate\Database\Migrations\Migration;//used for migrate and rollback
use Illuminate\Database\Schema\Blueprint;//used for creating table and coloumns
use Illuminate\Support\Facades\Schema;//used for functions like create, up and down

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');//foreign key
            $table->unsignedBigInteger('quiz_id');//foreign key
            $table->integer('marks');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();


            //foreign key
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempts');
    }
};
