<?php

use Illuminate\Database\Migrations\Migration;//used for migrate and rollbacks
use Illuminate\Database\Schema\Blueprint;//used for creatring tab=les and coloumns
use Illuminate\Support\Facades\Schema;//used for functions like create,up or down

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table)//used for creating table and coloumns
        {
            $table->id();//options id
            $table->unsignedBigInteger('question_id');//foreign key from questions
            $table->string('option_s',255);
            $table->boolean('correct_option')->default(false);//correct otpions used true or false
            $table->timestamps();

            //foreign key
           $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');//onDelete('cascade) is used if parent row is deleted all the child rows are also deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
