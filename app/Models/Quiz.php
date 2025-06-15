<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'question_text_ru', 'question_text_kk', 'question_text_en',
        'question_type',
        'options_ru', 'options_kk', 'options_en',
        'correct_answer_ru', 'correct_answer_kk', 'correct_answer_en',
    ];

    protected $casts = [
        'options_ru' => 'array',
        'options_kk' => 'array',
        'options_en' => 'array',
    ];

    /**
     * Get localized question text
     */
    public function getQuestionTextAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"question_text_$locale"} ?? $this->question_text_ru;
    }

    /**
     * Get localized options
     */
    public function getOptionsAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"options_$locale"} ?? $this->options_ru;
    }

    /**
     * Get localized correct answer
     */
    public function getCorrectAnswerAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"correct_answer_$locale"} ?? $this->correct_answer_ru;
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
