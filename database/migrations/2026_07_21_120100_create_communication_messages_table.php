<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communication_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('communication_templates')->nullOnDelete();
            $table->string('title');
            $table->string('channel')->default('email');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('audience_type')->default('all_members');
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ministry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('membership_type')->nullable();
            $table->string('membership_status')->nullable();
            $table->json('member_ids')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('scheduled_for')->nullable();
            $table->unsignedInteger('recipient_count')->default(0);
            $table->unsignedInteger('sent_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'scheduled_for']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_messages');
    }
};
