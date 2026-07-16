<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('category', 80)->index();
            $table->longText('request_text');
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('allow_follow_up')->default(false);
            $table->string('status', 30)->default('new')->index();
            $table->string('assigned_to')->nullable();
            $table->longText('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayer_requests');
    }
};
