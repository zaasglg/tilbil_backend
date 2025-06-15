<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'level_id',
        'title_ru', 'title_kk', 'title_en',
        'description_ru', 'description_kk', 'description_en',
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
     * Get localized description
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_$locale"} ?? $this->description_ru;
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
