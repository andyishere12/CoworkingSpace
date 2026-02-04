<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $fillable = [
        'nama_pemesanan',
        'kontak',
        'institusi',
        'purpose',
        'description',
        'attends',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'ruangan',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(DataMember::class, 'member_id');
    }
}
