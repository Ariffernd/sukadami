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
            $table->string('nama_p');
            $table->integer('nisn')->unique();
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
            $table->string('tmpt_ank'); //tinggal bersama orangtua/ wali

            $table->text('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('prov');
            $table->string('kabkot');
            $table->string('kec');
            $table->string('desa');
            $table->string('jrk_rmh'); //jarak dari rumah ke sekolah
            $table->string('wkt_tmph');//waktu tempuh ke sekolah


            $table->string('nm_ayh');
            $table->string('nik_ayh');
            $table->string('thn_lh_ayh');
            $table->string('pend_ayh');
            $table->string('peker_ayh');
            $table->string('sal_ayh'); //pendapatan ayh
            $table->integer('no_telp_ayh');

            $table->string('nm_ibu');
            $table->string('nik_ibu');
            $table->string('thn_lh_ibu');
            $table->string('peker_ibu');
            $table->string('pend_ibu');
            $table->string('sal_ibu'); //pendapatan ibu
            $table->integer('no_telp_ibu');

            $table->string('nm_wali');
            $table->string('nik_wali');
            $table->string('thn_lh_wali');
            $table->string('peker_wali');
            $table->string('pend_wali');
            $table->string('sal_wali'); //pendapatan wali
            $table->integer('no_telp_wali');
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
