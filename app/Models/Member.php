<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'first_name',
        'last_name',
        'other_names',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'home_area',
        'occupation',
        'marital_status',
        'emergency_contact_name',
        'emergency_contact_phone',
        'campus_id',
        'ministry_id',
        'membership_type',
        'membership_status',
        'first_visit_date',
        'joined_date',
        'is_baptized',
        'is_born_again',
        'photo_path',
        'notes',
        'sms_consent',
        'email_consent',
        'whatsapp_consent',
        'birthday_message_consent',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'first_visit_date' => 'date',
            'joined_date' => 'date',
            'is_baptized' => 'boolean',
            'is_born_again' => 'boolean',
            'sms_consent' => 'boolean',
            'email_consent' => 'boolean',
            'whatsapp_consent' => 'boolean',
            'birthday_message_consent' => 'boolean',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function ministry(): BelongsTo
    {
        return $this->belongsTo(Ministry::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->other_names,
            $this->last_name,
        ])));
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? Storage::url($this->photo_path) : null;
    }

    public const MEMBERSHIP_TYPES = [
        'visitor' => 'Visitor',
        'member' => 'Member',
        'leader' => 'Leader',
        'pastor' => 'Pastor',
        'volunteer' => 'Volunteer',
    ];

    public const STATUSES = [
        'pending' => 'Pending Review',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'transferred' => 'Transferred',
        'deceased' => 'Deceased',
    ];
}
