<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vocabulary extends Model
{
    protected $table = 'vocabulary';

    protected $fillable = [
        'lesson_id',
        'word_kz',
        'word_ru',
        'word_en',
        'transcription',
        'audio_url',
        'examples_kz',
        'examples_ru',
        'examples_en',
    ];

    protected $casts = [
        'examples_kz' => 'array',
        'examples_ru' => 'array',
        'examples_en' => 'array',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
