<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_names')->nullable();
            $table->string('gender', 40)->nullable();
            $table->date('date_of_birth')->nullable()->index();
            $table->string('phone', 50)->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('address', 350)->nullable();
            $table->string('home_area')->nullable();
            $table->string('occupation')->nullable();
            $table->string('marital_status', 40)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 50)->nullable();
            $table->foreignId('campus_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ministry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('membership_type', 40)->default('visitor')->index();
            $table->string('membership_status', 40)->default('pending')->index();
            $table->date('first_visit_date')->nullable();
            $table->date('joined_date')->nullable();
            $table->boolean('is_baptized')->default(false);
            $table->boolean('is_born_again')->default(false);
            $table->string('photo_path')->nullable();
            $table->longText('notes')->nullable();
            $table->boolean('sms_consent')->default(false);
            $table->boolean('email_consent')->default(false);
            $table->boolean('whatsapp_consent')->default(false);
            $table->boolean('birthday_message_consent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
