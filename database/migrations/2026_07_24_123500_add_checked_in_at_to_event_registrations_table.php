<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('event_registrations')
            && ! Schema::hasColumn('event_registrations', 'checked_in_at')
        ) {
            Schema::table('event_registrations', function (Blueprint $table) {
                $table->timestamp('checked_in_at')->nullable()->after('status');
                $table->index(['event_id', 'checked_in_at']);
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('event_registrations')
            && Schema::hasColumn('event_registrations', 'checked_in_at')
        ) {
            Schema::table('event_registrations', function (Blueprint $table) {
                $table->dropIndex(['event_id', 'checked_in_at']);
                $table->dropColumn('checked_in_at');
            });
        }
    }
};
