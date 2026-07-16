<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('church_name');
            $table->string('short_name')->nullable();
            $table->string('tagline')->nullable();
            $table->string('address', 350)->nullable();
            $table->string('phone_primary', 60)->nullable();
            $table->string('phone_secondary', 60)->nullable();
            $table->string('email')->nullable();
            $table->longText('service_times')->nullable();
            $table->longText('giving_details')->nullable();
            $table->string('footer_text', 500)->nullable();
            $table->string('facebook_url', 500)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('youtube_url', 500)->nullable();
            $table->string('tiktok_url', 500)->nullable();
            $table->string('telegram_url', 500)->nullable();
            $table->string('whatsapp_url', 500)->nullable();
            $table->string('x_url', 500)->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
