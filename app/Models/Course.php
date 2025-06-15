<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'level_id',
        'title',
        'description',
        'order',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
