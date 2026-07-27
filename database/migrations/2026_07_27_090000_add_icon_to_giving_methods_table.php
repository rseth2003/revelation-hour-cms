<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('giving_methods', function (Blueprint $table) {
            $table->string('icon_path', 500)->nullable()->after('provider');
        });
    }

    public function down(): void
    {
        Schema::table('giving_methods', function (Blueprint $table) {
            $table->dropColumn('icon_path');
        });
    }
};
