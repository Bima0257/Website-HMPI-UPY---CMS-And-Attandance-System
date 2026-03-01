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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('background_image')->nullable();
            $table->text('video_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('youtube_url')->nullable();
            $table->text('tiktok_url')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->enum('status', ['draft', 'published'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
