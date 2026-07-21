<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communication_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communication_message_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('member_name');
            $table->string('destination')->nullable();
            $table->string('status')->default('prepared');
            $table->text('failure_reason')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            $table->unique(['communication_message_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communication_recipients');
    }
};
