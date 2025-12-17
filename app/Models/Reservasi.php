<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(DataMember::class, 'member_id');
    }
}
