<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description', 350)->nullable();
            $table->longText('description')->nullable();
            $table->string('resident_pastor')->nullable();
            $table->text('pastor_bio')->nullable();
            $table->string('address', 350);
            $table->string('district')->nullable();
            $table->string('country')->default('Uganda');
            $table->string('phone_primary', 50)->nullable();
            $table->string('phone_secondary', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('service_times')->nullable();
            $table->string('map_url', 1000)->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('pastor_image_path')->nullable();
            $table->boolean('is_main_campus')->default(false)->index();
            $table->boolean('is_published')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
