<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'short_desc',  // ВАЖНО! Добавляем это поле
        'full_desc',
        'image',
        'tag',
        'date_string',
        'type',
        'date',
        'participants',
        'duration'
    ];

    protected $casts = [
        'full_desc' => 'array',
        'date' => 'array'
    ];
}
