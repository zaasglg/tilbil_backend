<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'course_id',
        'title_ru', 'title_kk', 'title_en',
        'type',
        'content_ru', 'content_kk', 'content_en',
        'audio_url',
        'video_url',
        'order',
    ];

    /**
     * Get localized title
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_$locale"} ?? $this->title_ru;
    }

    /**
     * Get localized content
     */
    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"content_$locale"} ?? $this->content_ru;
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
