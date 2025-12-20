<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hadir extends Model
{
    protected $table = 'hadir';
    protected $fillable = [
        'nama',
        'type',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'durasi'
    ];
    
    protected $dates = ['tanggal'];
    
    public function member()
    {
        return $this->belongsTo(DataMember::class, 'nama', 'nama');
    }
}