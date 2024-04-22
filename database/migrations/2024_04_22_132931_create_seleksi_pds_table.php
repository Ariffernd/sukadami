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
        Schema::create('seleksi_pds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained()->onDelete('cascade');
            $table->foreignId('formulir_id')->constrained()->onDelete('cascade');
            $table->string('hasil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seleksi_pds');
    }
};
