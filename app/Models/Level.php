<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name_ru', 'name_kk', 'name_en',
        'description_ru', 'description_kk', 'description_en'
    ];

    /**
     * Get localized name
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"name_$locale"} ?? $this->name_ru;
    }

    /**
     * Get localized description
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_$locale"} ?? $this->description_ru;
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
