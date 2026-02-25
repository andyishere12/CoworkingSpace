<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'organizer',
        'title',
        'description',
        'start_date',
        'end_date',
        'jumlah_peserta',
        'status',
    ];

    /**
     * Relationship: Event belongs to a member (kept for backward compatibility)
     */
    public function member()
    {
        return $this->belongsTo(DataMember::class, 'member_id');
    }

    /**
     * Accessor: Alias title as nama_event
     */
    public function getNamaEventAttribute()
    {
        return $this->title;
    }

    /**
     * Accessor: Alias description as deskripsi
     */
    public function getDeskripsiAttribute()
    {
        return $this->description;
    }

    /**
     * Accessor: Alias start_date as tanggal_event
     */
    public function getTanggalEventAttribute()
    {
        return $this->start_date;
    }

    /**
     * Accessor: Get organizer name (from text field, fallback to member name)
     */
    public function getOrganizerNameAttribute()
    {
        return $this->organizer ?: ($this->member->nama ?? 'N/A');
    }
}