<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'hadir';

    protected $fillable = [
        'data_member_id',
        'check_in',
        'check_out',
    ];

    public function member()
    {
        return $this->belongsTo(DataMember::class, 'data_member_id');
    }
}
