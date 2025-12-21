<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'event_date',
        'registered_participants',
        'actual_attendees',
        'attendance_rate',
        'revenue',
        'expenses',
        'profit',
        'event_status',
        'feedback_summary',
        'rating'
    ];

    protected $casts = [
        'event_date' => 'date',
        'revenue' => 'decimal:2',
        'expenses' => 'decimal:2',
        'profit' => 'decimal:2',
        'rating' => 'decimal:2'
    ];

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}