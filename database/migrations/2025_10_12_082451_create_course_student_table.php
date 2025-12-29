<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('course_student', function (Blueprint $table) {
    $table->id();
    // Foreign keys
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->foreignId('course_id')->constrained()->onDelete('cascade');
    
    // Payment status for this specific enrollment
    $table->enum('payment', ['done', 'pending'])->default('pending'); 

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_student');
    }
};
