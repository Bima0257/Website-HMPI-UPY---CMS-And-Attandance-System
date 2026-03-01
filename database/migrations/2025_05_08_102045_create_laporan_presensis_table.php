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
        Schema::create('laporan_presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_code_id');
            $table->enum('status', ['Hadir', 'Izin', 'Alpha', 'Telat'])->default('Alpha');
            $table->date('tanggal_presensi');
            $table->time('jam_presensi');
            $table->time('waktu_mulai')->nullable();
            $table->time('batas_telat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_presensis');
    }
};
