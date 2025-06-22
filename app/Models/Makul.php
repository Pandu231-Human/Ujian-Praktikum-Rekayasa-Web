<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makul extends Model
{
    protected $table = 'makul';
    
    protected $fillable = [
        'nama', 'kode', 'sks'
    ];
}