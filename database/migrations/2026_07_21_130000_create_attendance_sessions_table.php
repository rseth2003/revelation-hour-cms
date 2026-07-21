<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('service_type')->default('sunday_service');
            $table->dateTime('held_at');
            $table->unsignedInteger('adult_visitors')->default(0);
            $table->unsignedInteger('youth_visitors')->default(0);
            $table->unsignedInteger('children_visitors')->default(0);
            $table->unsignedInteger('registered_members_present')->default(0);
            $table->unsignedInteger('total_attendance')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['held_at', 'service_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};
