<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_name',
        'short_name',
        'tagline',
        'address',
        'phone_primary',
        'phone_secondary',
        'email',
        'service_times',
        'giving_details',
        'footer_text',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'tiktok_url',
        'telegram_url',
        'whatsapp_url',
        'x_url',
        'logo_path',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? Storage::url($this->logo_path) : null;
    }

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'church_name' => 'Revelation Hour Ministries International',
            'short_name' => 'RHMI',
            'tagline' => 'Word. Worth. Wonder.',
            'address' => 'Valley Road, Canaansite Estate, Nakwero Gayaza',
            'phone_primary' => '+256 774 328 127',
            'phone_secondary' => '+256 784 537 003',
            'footer_text' => 'Revelation Hour Ministries International',
        ]);
    }
}
