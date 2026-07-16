<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('speaker')->nullable();
            $table->string('series')->nullable();
            $table->string('bible_passage')->nullable();
            $table->text('description')->nullable();
            $table->string('youtube_url', 500)->nullable();
            $table->string('audio_path')->nullable();
            $table->string('notes_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->date('sermon_date')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_published')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
