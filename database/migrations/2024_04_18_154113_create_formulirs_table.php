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
            $table->string('nama')->nullable();
            $table->string('nama_p')->nullable();
            $table->bigInteger('nisn')->unique()->nullable();
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('tl_lahir')->nullable(); //tempat lahir
            $table->date('tg_lahir')->nullable();
            $table->string('jk')->nullable();
            $table->string('cita')->nullable(); //cita-cita
            $table->string('agama')->nullable();
            $table->integer('anak_ke')->nullable(); //anak ke 1/2/3
            $table->integer('anak_sdr')->nullable(); //saudara anak 
            $table->string('status_ank')->nullable(); //yatim piatu etc.
            $table->string('tmpt_ank')->nullable();
            $table->integer('brt_bdn')->nullable(); //tinggal bersama orangtua/ wali
            $table->string('sat_brt')->nullable(); //tinggal bersama orangtua/ wali
            $table->integer('tngi_bdn')->nullable(); //tinggal bersama orangtua/ wali
            $table->string('sat_tngi')->nullable(); //tinggal bersama orangtua/ wali

            $table->text('alamat')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->char('province_id')->nullable();
            $table->char('regency_id')->nullable();
            $table->char('district_id')->nullable();
            $table->char('village_id')->nullable();
            $table->string('jrk_rmh')->nullable(); //jarak dari rumah ke sekolah
            $table->string('sat_jrk')->nullable(); //jarak satuan
            $table->string('wkt_tmph')->nullable();//waktu tempuh ke sekolah
            $table->string('sat_tmph')->nullable();//waktu tempuh ke sekolah


            $table->string('nm_ayh')->nullable();
            $table->string('nik_ayh')->nullable();
            $table->string('thn_lh_ayh')->nullable();
            $table->string('pend_ayh')->nullable();
            $table->string('peker_ayh')->nullable();
            $table->string('sal_ayh')->nullable(); //pendapatan ayh
            $table->bigInteger('no_telp_ayh')->nullable();

            $table->string('nm_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->string('thn_lh_ibu')->nullable();
            $table->string('peker_ibu')->nullable();
            $table->string('pend_ibu')->nullable();
            $table->string('sal_ibu')->nullable(); //pendapatan ibu
            $table->bigInteger('no_telp_ibu')->nullable();

            $table->string('nm_wali')->nullable();
            $table->string('nik_wali')->nullable();
            $table->string('thn_lh_wali')->nullable();
            $table->string('peker_wali')->nullable();
            $table->string('pend_wali')->nullable();
            $table->string('sal_wali')->nullable(); //pendapatan wali
            $table->bigInteger('no_telp_wali')->nullable();

            
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
