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
        Schema::create('data_members', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->bigInteger('npm');
            $table->enum('divisi', ['BPH', 'PSDM', 'P3M', 'KOMINFO', 'KEMIRA', 'HUBLU', 'SEKRETARIS', 'BENDAHARA']);
            $table->enum('jabatan', ['KETUA', 'WAKIL KETUA', 'KETUA DIVISI', 'ANGGOTA', 'BENDAHARA', 'SEKERTARIS']);
            $table->string('link_ig')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_members');
    }
};
