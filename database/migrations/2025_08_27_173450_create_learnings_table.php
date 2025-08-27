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
        Schema::create('learnings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vedio');
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->json('steps')->nullable();
            $table->enum('category', ['visual', 'auditory', 'verbal', 'sensory']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learnings');
    }
};
