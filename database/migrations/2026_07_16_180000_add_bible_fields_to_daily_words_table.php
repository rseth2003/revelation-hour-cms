<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_words', function (Blueprint $table) {
            $table->string('bible_version', 30)->nullable()->after('title');
            $table->string('bible_book', 80)->nullable()->after('bible_version');
            $table->unsignedSmallInteger('bible_chapter')->nullable()->after('bible_book');
            $table->unsignedSmallInteger('bible_verse_start')->nullable()->after('bible_chapter');
            $table->unsignedSmallInteger('bible_verse_end')->nullable()->after('bible_verse_start');
        });
    }

    public function down(): void
    {
        Schema::table('daily_words', function (Blueprint $table) {
            $table->dropColumn([
                'bible_version',
                'bible_book',
                'bible_chapter',
                'bible_verse_start',
                'bible_verse_end',
            ]);
        });
    }
};
