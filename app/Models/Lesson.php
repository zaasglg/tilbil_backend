<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'type',
        'content',
        'audio_url',
        'video_url',
        'order',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
