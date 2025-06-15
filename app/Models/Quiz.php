<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
