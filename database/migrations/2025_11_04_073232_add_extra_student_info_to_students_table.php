<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('profile_image');
            $table->string('father_phone')->nullable()->after('father_name');
            $table->string('mother_name')->nullable()->after('father_phone');
            $table->string('mother_phone')->nullable()->after('mother_name');
            $table->string('alt_guardian_name')->nullable()->after('mother_phone');
            $table->string('alt_guardian_phone')->nullable()->after('alt_guardian_name');
            $table->string('blood_group')->nullable()->after('alt_guardian_phone');
            $table->string('religion')->nullable()->after('blood_group');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('religion');
            $table->text('present_address')->nullable()->after('gender');
            $table->text('permanent_address')->nullable()->after('present_address');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'father_name', 'father_phone',
                'mother_name', 'mother_phone',
                'alt_guardian_name', 'alt_guardian_phone',
                'blood_group', 'religion', 'gender',
                'present_address', 'permanent_address'
            ]);
        });
    }
};

