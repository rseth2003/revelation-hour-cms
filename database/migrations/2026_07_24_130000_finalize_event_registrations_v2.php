<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('event_registrations')) {
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
                $table->timestamp('checked_in_at')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['event_id', 'phone']);
                $table->index(['event_id', 'status']);
                $table->index(['event_id', 'checked_in_at']);
            });

            return;
        }

        Schema::table('event_registrations', function (Blueprint $table) {
            if (! Schema::hasColumn('event_registrations', 'member_id')) {
                $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('event_registrations', 'campus_id')) {
                $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('event_registrations', 'registration_type')) {
                $table->string('registration_type', 20)->default('visitor');
            }

            if (! Schema::hasColumn('event_registrations', 'status')) {
                $table->string('status', 20)->default('pending');
            }

            if (! Schema::hasColumn('event_registrations', 'checked_in_at')) {
                $table->timestamp('checked_in_at')->nullable();
            }

            if (! Schema::hasColumn('event_registrations', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        // This finalization migration is intentionally non-destructive.
    }
};
