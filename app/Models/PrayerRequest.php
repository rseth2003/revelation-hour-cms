<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'category', 'request_text',
        'is_anonymous', 'allow_follow_up', 'status',
        'assigned_to', 'internal_notes',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'allow_follow_up' => 'boolean',
        ];
    }

    public const CATEGORIES = [
        'General Prayer', 'Healing', 'Family', 'Financial',
        'Thanksgiving', 'Deliverance', 'Salvation', 'Guidance', 'Other',
    ];

    public const STATUSES = [
        'new' => 'New',
        'in_progress' => 'In Progress',
        'prayed_for' => 'Prayed For',
        'closed' => 'Closed',
    ];
}
