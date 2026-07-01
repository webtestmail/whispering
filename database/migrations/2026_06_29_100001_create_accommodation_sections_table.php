<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodation_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accommodation_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('position_order')->default(1);
            $table->string('default_section_name')->nullable();
            $table->string('section_title')->nullable();
            $table->string('section_subtitle')->nullable();
            $table->string('section_headline')->nullable();
            $table->text('description')->nullable();
            $table->string('button_name')->nullable();
            $table->string('button_link')->nullable();
            $table->string('section_subheading')->nullable();
            $table->string('section_image')->nullable();
            $table->text('more_images')->nullable();
            $table->string('video_link')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accommodation_sections');
    }
};
