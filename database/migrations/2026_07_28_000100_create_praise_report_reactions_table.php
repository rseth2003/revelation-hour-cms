<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('praise_report_reactions')) {
            Schema::create('praise_report_reactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('praise_report_id')->constrained()->cascadeOnDelete();
                $table->string('reaction', 30);
                $table->string('ip_hash', 64);
                $table->timestamps();
                $table->unique(['praise_report_id', 'ip_hash']);
                $table->index(['praise_report_id', 'reaction']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('praise_report_reactions');
    }
};
