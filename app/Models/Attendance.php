<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'hadir';

    protected $fillable = [
        'member_id',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'durasi',
    ];

    public function member()
    {
        return $this->belongsTo(DataMember::class, 'member_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'member_id');
    }
}
