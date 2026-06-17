<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = [
        'title',
        'short_desc',  // ← ДОБАВИТЬ ЭТО!
        'details',
        'image'
    ];

    protected $casts = [
        'details' => 'array'
    ];
}
