<?php
use Illuminate\Database\Migrations\Migration;//used to migrate and for rollback in up/down function
use Illuminate\Database\Schema\Blueprint;//schema and blueprints used for creatingtables na coloumns respectively
use Illuminate\Support\Facades\Schema;//its provides the methods like create and drop

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table)//used to create tables and coloums
        {
            $table->id(); // primary key
            $table->string('name', 100); 
            $table->string('email', 150)->unique(); 
            $table->string('password', 255); 
            $table->enum('role', ['student', 'admin'])->default('student'); 
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

