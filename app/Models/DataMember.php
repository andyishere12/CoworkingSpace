<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMember extends Model
{
    protected $table = 'data_members';
    protected $guarded = [];  // aman, semua field bisa diisi
    
}
