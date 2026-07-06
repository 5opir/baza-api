<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credit extends Model
{
    protected $fillable = ['film_id', 'role', 'name', 'sort_order'];

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }
}