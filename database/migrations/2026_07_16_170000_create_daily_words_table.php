<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('daily_words',function(Blueprint $t){$t->id();$t->string('title');$t->string('scripture_reference')->nullable();$t->text('scripture_text')->nullable();$t->longText('message')->nullable();$t->string('author')->nullable();$t->date('publish_date')->index();$t->string('poster_path')->nullable();$t->string('audio_path')->nullable();$t->boolean('is_featured')->default(false)->index();$t->boolean('is_published')->default(false)->index();$t->timestamps();}); } public function down(): void { Schema::dropIfExists('daily_words'); } };
