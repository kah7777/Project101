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
        Schema::create('child_mood_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            
            $table->enum('mood', [
                'angry',
                'happy',
                'unsure',
                'anxious',
                'sad'
            ]);

            $table->enum('participation', [
                'excellent',
                'good',
                'average',
                'poor'
            ]);

            $table->enum('activity_completion', [
                'completed',
                'partial',
                'not_completed'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_mood_evaluations');
    }
};
