<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();             // course title
            $table->text('description')->nullable();       // course description
            $table->string('image')->nullable();           // course image path
            $table->string('instructor')->nullable();      // instructor name
            $table->decimal('rating', 2, 1)->nullable();   // e.g. 4.5
            $table->integer('reviews')->default(0);        // number of reviews
            $table->integer('lectures_count')->nullable();       // number of lectures
            $table->string('duration')->nullable();        // e.g. "10h 30m"
            $table->string('skill_level')->nullable();     // e.g. Beginner, Advanced
            $table->string('language')->nullable();        // e.g. English
            $table->decimal('fee', 10, 2)->default(0);     // regular price
            $table->decimal('offer_price', 10, 2)->nullable(); // discounted price
            $table->dateTime('offer_expires_at')->nullable();  // offer expiry date
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
