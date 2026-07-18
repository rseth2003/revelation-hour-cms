<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('background_image_path')->nullable();
            $table->string('poster_image_path')->nullable();
            $table->string('primary_button_text', 80)->nullable();
            $table->string('primary_button_url', 500)->nullable();
            $table->string('secondary_button_text', 80)->nullable();
            $table->string('secondary_button_url', 500)->nullable();
            $table->boolean('open_links_in_new_tab')->default(false);
            $table->unsignedTinyInteger('overlay_opacity')->default(55);
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
