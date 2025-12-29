<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/..._create_lectures_table.php

        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Links to the Course model
            $table->string('title');
            $table->enum('type', ['pre_recorded', 'live']); // Use 'pre_recorded' or 'live'
            $table->string('youtube_link'); // The Unlisted YouTube URL or Live Stream URL
            $table->dateTime('live_scheduled_at')->nullable(); // For live classes
            $table->integer('order')->default(0); // For display order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
