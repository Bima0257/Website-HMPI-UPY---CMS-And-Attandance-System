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
        Schema::create('bread_crumb_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->string('about');
            $table->string('all_programs');
            $table->string('program_detail');
            $table->string('our_teams');
            $table->string('all_articles');
            $table->string('detail_article');
            $table->enum('status', ['published', 'draft']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bread_crumb_backgrounds');
    }
};
