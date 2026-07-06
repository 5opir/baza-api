<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    protected $fillable = [
        'category', 'title', 'company',
        'description', 'thumbnail', 'video_url',
    ];
}