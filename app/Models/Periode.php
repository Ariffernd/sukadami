<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'ta',
        'gel',
        'status',
    ];

    public function formulir(){
        return $this->hasMany(Formulir::class);
    }
}
