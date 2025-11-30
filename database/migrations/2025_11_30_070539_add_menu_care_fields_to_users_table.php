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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password'); // 'user' or 'admin'
            $table->string('phone_number')->nullable()->after('role');
            $table->string('profile_photo_path')->nullable()->after('phone_number');
            $table->date('last_quiz_date')->nullable()->after('profile_photo_path');
            $table->timestamp('last_quiz_timestamp')->nullable()->after('last_quiz_date'); // For 24-hour validity check
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone_number',
                'profile_photo_path',
                'last_quiz_date',
                'last_quiz_timestamp',
            ]);
        });
    }
};
