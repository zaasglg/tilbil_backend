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
        Schema::table('quizzes', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('question_text', 'question_text_ru');
            $table->renameColumn('options', 'options_ru');
            $table->renameColumn('correct_answer', 'correct_answer_ru');
            
            // Add new translation columns as nullable
            $table->text('question_text_kk')->nullable()->after('question_text_ru');
            $table->text('question_text_en')->nullable()->after('question_text_kk');
            $table->json('options_kk')->nullable()->after('options_ru');
            $table->json('options_en')->nullable()->after('options_kk');
            $table->string('correct_answer_kk')->nullable()->after('correct_answer_ru');
            $table->string('correct_answer_en')->nullable()->after('correct_answer_kk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Remove translation columns
            $table->dropColumn([
                'question_text_kk', 'question_text_en',
                'options_kk', 'options_en',
                'correct_answer_kk', 'correct_answer_en'
            ]);
            
            // Rename back to original
            $table->renameColumn('question_text_ru', 'question_text');
            $table->renameColumn('options_ru', 'options');
            $table->renameColumn('correct_answer_ru', 'correct_answer');
        });
    }
};
