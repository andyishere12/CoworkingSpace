<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadir extends Model
{
    use HasFactory;

    protected $table = 'hadir';

    protected $fillable = [
        'member_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'durasi'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];


    public function member()
    {
        return $this->belongsTo(DataMember::class, 'member_id');
    }

}