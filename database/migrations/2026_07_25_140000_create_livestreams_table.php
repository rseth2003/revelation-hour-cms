<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up(): void {
  if (!Schema::hasTable('livestreams')) Schema::create('livestreams', function(Blueprint $table){
   $table->id(); $table->string('title',180); $table->string('slug',210)->unique();
   $table->string('subtitle')->nullable(); $table->string('speaker',150)->nullable(); $table->string('series',150)->nullable();
   $table->longText('description')->nullable(); $table->string('platform',30)->default('youtube'); $table->string('stream_url',1000);
   $table->string('thumbnail_path')->nullable(); $table->timestamp('scheduled_start')->nullable(); $table->timestamp('scheduled_end')->nullable();
   $table->string('manual_status',20)->default('automatic'); $table->boolean('is_featured')->default(false);
   $table->boolean('show_on_homepage')->default(false); $table->boolean('is_published')->default(false); $table->unsignedInteger('sort_order')->default(0);
   $table->timestamps(); $table->index(['is_published','scheduled_start']);
  });
 }
 public function down(): void { Schema::dropIfExists('livestreams'); }
};
