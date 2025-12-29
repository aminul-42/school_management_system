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
       Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('target_type', ['all', 'course', 'student'])->default('all');
            $table->unsignedBigInteger('target_id')->nullable(); // course_id or student_id
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Optional foreign keys (not enforced to keep flexibility)
            // $table->foreign('target_id')->references('id')->on('courses')->onDelete('cascade');
            // $table->foreign('target_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
