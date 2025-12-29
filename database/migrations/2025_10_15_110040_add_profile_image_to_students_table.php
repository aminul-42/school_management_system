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
        // Use Schema::table to modify the existing 'students' table
        Schema::table('students', function (Blueprint $table) {
            // Add the profile_image column, which stores the file path.
            // It is nullable, meaning existing records don't need a value.
            $table->string('profile_image')->nullable()->after('phone_number'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the operation by dropping the column
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('profile_image');
        });
    }
};
