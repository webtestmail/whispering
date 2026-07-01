<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position_order')->default(1);
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->string('season_tag')->nullable();
            $table->string('season_style')->nullable();
            $table->string('months')->nullable();
            $table->string('temperature')->nullable();
            $table->string('title');
            $table->text('listing_description')->nullable();
            $table->string('listing_image')->nullable();
            $table->json('highlights')->nullable();
            $table->string('link_text')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
