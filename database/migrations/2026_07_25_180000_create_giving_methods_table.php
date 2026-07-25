<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('giving_methods', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('provider', 40)->default('custom');
            $table->string('account_name', 160)->nullable();
            $table->string('account_number', 100)->nullable();
            $table->string('bank_name', 160)->nullable();
            $table->string('branch_name', 160)->nullable();
            $table->string('swift_code', 80)->nullable();
            $table->text('instructions')->nullable();
            $table->string('button_label', 80)->nullable();
            $table->string('button_url', 1000)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('giving_methods')->insert([
            [
                'title' => 'MTN Mobile Money', 'provider' => 'mtn_momo',
                'instructions' => 'The church administration will add the official giving number and account name here.',
                'is_featured' => true, 'is_published' => true, 'sort_order' => 10,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'title' => 'MTN MoMoPay', 'provider' => 'mtn_momopay',
                'instructions' => 'The official merchant code and payment instructions will be added through the CMS.',
                'is_featured' => false, 'is_published' => true, 'sort_order' => 20,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'title' => 'Bank Transfer', 'provider' => 'bank',
                'instructions' => 'Official bank account details will be published by the church administration.',
                'is_featured' => false, 'is_published' => true, 'sort_order' => 30,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('giving_methods');
    }
};
