<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('praise_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180);
            $table->string('slug', 200)->unique();
            $table->string('person_name', 150)->nullable();
            $table->string('category', 100)->nullable();
            $table->text('summary')->nullable();
            $table->longText('testimony');
            $table->string('scripture_reference', 150)->nullable();
            $table->text('scripture_text')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('video_path')->nullable();
            $table->string('video_url', 500)->nullable();
            $table->string('audio_path')->nullable();
            $table->date('testimony_date')->nullable();
            $table->string('status', 30)->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('show_on_homepage')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('praise_report_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('praise_report_id')->constrained()->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('email')->nullable();
            $table->text('message');
            $table->string('status', 20)->default('pending');
            $table->string('ip_hash', 64)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('praise_report_comments');
        Schema::dropIfExists('praise_reports');
    }
};
