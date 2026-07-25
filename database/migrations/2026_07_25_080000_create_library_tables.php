<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('library_categories')) {
            Schema::create('library_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name',120);
                $table->string('slug',150)->unique();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('is_published')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('library_resources')) {
            Schema::create('library_resources', function (Blueprint $table) {
                $table->id();
                $table->foreignId('library_category_id')->nullable()->constrained('library_categories')->nullOnDelete();
                $table->string('title',180);
                $table->string('slug',210)->unique();
                $table->string('author',150)->nullable();
                $table->string('resource_type',40)->default('book');
                $table->longText('description')->nullable();
                $table->string('cover_path')->nullable();
                $table->string('file_path')->nullable();
                $table->unsignedInteger('price_ugx')->default(0);
                $table->boolean('is_paid')->default(false);
                $table->boolean('allow_read_online')->default(true);
                $table->boolean('allow_download')->default(true);
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_published')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamp('published_at')->nullable();
                $table->unsignedBigInteger('view_count')->default(0);
                $table->unsignedBigInteger('download_count')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('library_resources');
        Schema::dropIfExists('library_categories');
    }
};
