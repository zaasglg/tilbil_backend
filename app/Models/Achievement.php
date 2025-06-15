<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'icon_url',
        'type',
        'criteria',
    ];

    protected $casts = [
        'criteria' => 'array',
    ];

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
