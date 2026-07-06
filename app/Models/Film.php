<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    protected $fillable = [
        'type', 'title', 'genre', 'format',
        'cover', 'poster', 'description', 'full_description', 'trailer_url',
    ];

    /**
     * Титры фильма (режиссёр, сценарий, актёры и т.д.)
     */
    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class)->orderBy('sort_order');
    }
}