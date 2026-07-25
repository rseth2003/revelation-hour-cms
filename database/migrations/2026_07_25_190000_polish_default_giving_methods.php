<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('giving_methods')) return;

        $momoPay = DB::table('giving_methods')->where('provider', 'mtn_momopay')->first();
        if ($momoPay) {
            DB::table('giving_methods')->where('id', $momoPay->id)->update([
                'title' => 'Airtel Money',
                'provider' => 'airtel_money',
                'account_name' => null,
                'account_number' => null,
                'bank_name' => null,
                'branch_name' => null,
                'swift_code' => null,
                'instructions' => null,
                'updated_at' => now(),
            ]);
        } elseif (!DB::table('giving_methods')->where('provider', 'airtel_money')->exists()) {
            DB::table('giving_methods')->insert([
                'title' => 'Airtel Money', 'provider' => 'airtel_money',
                'is_featured' => false, 'is_published' => true, 'sort_order' => 20,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        $bank = DB::table('giving_methods')->where('provider', 'bank')->first();
        if ($bank) {
            DB::table('giving_methods')->where('id', $bank->id)->update([
                'title' => 'Visa & Mastercard',
                'provider' => 'cards',
                'account_name' => null,
                'account_number' => null,
                'bank_name' => null,
                'branch_name' => null,
                'swift_code' => null,
                'instructions' => null,
                'button_label' => null,
                'button_url' => null,
                'updated_at' => now(),
            ]);
        } elseif (!DB::table('giving_methods')->where('provider', 'cards')->exists()) {
            DB::table('giving_methods')->insert([
                'title' => 'Visa & Mastercard', 'provider' => 'cards',
                'is_featured' => false, 'is_published' => true, 'sort_order' => 30,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        DB::table('giving_methods')->where('provider', 'mtn_momo')->update([
            'instructions' => null,
            'updated_at' => now(),
        ]);
    }

    public function down(): void {}
};
