<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Formulir extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'periode_id',
        'nama',
        'nama_p',
        'nisn',
        'nik',
        'no_kk',
        'tl_lahir', //tempat lahir
        'tg_lahir',
        'jk',
        'cita', //cita-cita
        'agama',
        'anak_ke', //anak ke 1/2/3
        'anak_sdr', //saudara anak
        'status_ank', //yatim piatu etc.
        'tmpt_ank', //tinggal bersama orangtua/ wali
        'brt_bdn',
        'sat_brt',
        'tngi_bdn',
        'sat_tngi',

        'alamat',
        'rt',
        'rw',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'jrk_rmh',
        'sat_jrk', //satuan jarak
        'wkt_tmph',
        'sat_tmph', //

        'nm_ayh',
        'nik_ayh',
        'thn_lh_ayh',
        'pend_ayh',
        'peker_ayh',
        'sal_ayh', //pendapatan ayh
        'no_telp_ayh',

        'nm_ibu',
        'nik_ibu',
        'thn_lh_ibu',
        'peker_ibu',
        'pend_ibu',
        'sal_ibu', //pendapatan ibu
        'no_telp_ibu',

        'nm_wali',
        'nik_wali',
        'thn_lh_wali',
        'peker_wali',
        'pend_wali',
        'sal_wali', //pendapatan wali
        'no_telp_wali',

    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }




    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function periode(){
        return $this->belongsTo(Periode::class);
    }


    // PANGGUL DATA WILAYAH
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
