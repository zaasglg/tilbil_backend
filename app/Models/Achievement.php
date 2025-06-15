<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    protected $fillable = [
        'code',
        'title_ru', 'title_kk', 'title_en',
        'description_ru', 'description_kk', 'description_en',
        'icon_url',
        'type',
        'criteria',
    ];

    protected $casts = [
        'criteria' => 'array',
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

    /**
     * Users who have earned this achievement
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withTimestamps()
            ->withPivot('progress', 'completed_at');
    }
}
