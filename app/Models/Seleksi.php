<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'ta',
        'gel',
        'tgl_sel',
        'ket',
    ];
}
