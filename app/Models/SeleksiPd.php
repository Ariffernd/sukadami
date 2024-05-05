<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeleksiPd extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'seleksi_id',
        'periode_id',
        'formulir_id',
        'hasil',
    ];
    
    public function periode(){
        return $this->belongsTo(Periode::class);
    }

    public function formulir(){
        return $this->belongsTo(Formulir::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}