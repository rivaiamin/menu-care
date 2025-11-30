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
        Schema::create('daily_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->json('answers'); // Array of 10 answers: [0, 1, 2, 3, 4]
            $table->integer('score'); // Range: 0-40 (after reverse scoring)
            $table->enum('category', ['rendah', 'sedang', 'berat']);
            $table->timestamps(); // created_at is critical for 24-hour validity check
            
            // Optional: Ensure one quiz per user per day (can be removed if 24h rule is strictly enforced)
            // $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_quizzes');
    }
};
