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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel qr_codes
            $table->foreignId('qr_code_id')->constrained('qr_codes')->onDelete('cascade');

            // Status presensi
            $table->enum('status', ['Hadir', 'Izin', 'Alpha'])->default('Alpha');

            // Tanggal dan jam presensi
            $table->date('tanggal_presensi');
            $table->time('jam_presensi');

            $table->timestamps();

            $table->index(['qr_code_id', 'tanggal_presensi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
