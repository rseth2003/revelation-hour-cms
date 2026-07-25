<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GivingMethod extends Model
{
    use HasFactory;

    public const PROVIDERS = [
        'mtn_momo' => 'MTN Mobile Money',
        'airtel_money' => 'Airtel Money',
        'cards' => 'Visa / Mastercard',
        'cash' => 'Cash / In Person',
        'custom' => 'Other Method',
    ];

    protected $fillable = [
        'title', 'provider', 'account_name', 'account_number', 'bank_name',
        'branch_name', 'swift_code', 'instructions', 'button_label', 'button_url',
        'is_featured', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getProviderLabelAttribute(): string
    {
        return self::PROVIDERS[$this->provider] ?? $this->title;
    }
}
