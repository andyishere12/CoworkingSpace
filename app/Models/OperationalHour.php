<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalHour extends Model
{
    protected $fillable = [
        'day',
        'open_time',
        'close_time',
        'is_closed'
    ];

    protected $casts = [
        'is_closed' => 'boolean'
    ];
}