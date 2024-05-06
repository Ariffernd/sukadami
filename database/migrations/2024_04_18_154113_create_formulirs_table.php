<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formulirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('periode_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('nama_p')->nullable();
            $table->bigInteger('nisn')->unique();
            $table->string('nik');
            $table->string('no_kk');
            $table->string('tl_lahir'); //tempat lahir
            $table->date('tg_lahir');
            $table->string('jk');
            $table->string('cita'); //cita-cita
            $table->string('agama');
            $table->integer('anak_ke'); //anak ke 1/2/3
            $table->integer('anak_sdr'); //saudara anak 
            $table->string('status_ank'); //yatim piatu etc.
            $table->string('tmpt_ank');
            $table->integer('brt_bdn')->nullable();
            $table->string('sat_brt')->nullable();
            $table->integer('tngi_bdn')->nullable();
            $table->string('sat_tngi')->nullable();
            $table->integer('lkrkp')->nullable(); //lingkar kepala
            $table->string('sat_lkrkp')->nullable(); //satuan lingkar kepala
            $table->string('asal_sklh')->nullable();

            $table->text('alamat');
            $table->integer('rt');
            $table->integer('rw');
            $table->char('province_id');
            $table->char('regency_id');
            $table->char('district_id');
            $table->char('village_id');
            $table->string('jrk_rmh')->nullable(); //jarak dari rumah ke sekolah
            $table->string('sat_jrk')->nullable(); //jarak satuan
            $table->string('wkt_tmph')->nullable();//waktu tempuh ke sekolah
            $table->string('sat_tmph')->nullable();//waktu tempuh ke sekolah


            $table->string('nm_ayh');
            $table->string('nik_ayh');
            $table->string('thn_lh_ayh');
            $table->string('pend_ayh');
            $table->string('peker_ayh');
            $table->string('sal_ayh'); //pendapatan ayh
            $table->bigInteger('no_telp_ayh');

            $table->string('nm_ibu');
            $table->string('nik_ibu');
            $table->string('thn_lh_ibu');
            $table->string('peker_ibu');
            $table->string('pend_ibu');
            $table->string('sal_ibu'); //pendapatan ibu
            $table->bigInteger('no_telp_ibu');

            $table->string('nm_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('thn_lh_wali')->nullable();
            $table->string('peker_wali')->nullable();
            $table->string('pend_wali')->nullable();
            $table->string('sal_wali')->nullable(); //pendapatan wali
            $table->bigInteger('no_telp_wali')->nullable();

            $table->string('ijazah');
            $table->string('kk');
            $table->string('akte');

            
            $table->foreign('province_id')->references('id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('regency_id')->references('id')->on('regencies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('village_id')->references('id')->on('villages')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulirs');
    }
};
