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
        Schema::create('vocabulary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->string('word_kz');
            $table->string('word_ru');
            $table->string('word_en');
            $table->string('transcription')->nullable();
            $table->string('audio_url')->nullable();
            $table->json('examples_kz')->nullable();
            $table->json('examples_ru')->nullable();
            $table->json('examples_en')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabulary');
    }
};
