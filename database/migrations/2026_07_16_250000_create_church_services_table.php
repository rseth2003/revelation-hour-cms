<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('church_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('service_type', 60)->index();
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->date('service_date')->index();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->longText('notes')->nullable();
            $table->string('status', 30)->default('open')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_services');
    }
};
