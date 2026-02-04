<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMember extends Model
{
    protected $table = 'data_members';

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'alamat',
        'email',
        'no_hp',
        'aktivitas',
        'institusi',
        'type',
        'status',
        'foto',
    ];
}
