<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('event_registrations')) {
            return;
        }

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name', 180);
            $table->string('phone', 40);
            $table->string('email')->nullable();
            $table->string('registration_type', 20)->default('visitor');
            $table->string('status', 20)->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'phone']);
            $table->index(['event_id', 'status']);
            $table->index('registration_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
