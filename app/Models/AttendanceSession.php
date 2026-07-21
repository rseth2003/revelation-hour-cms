<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'campus_id',
        'event_id',
        'title',
        'service_type',
        'held_at',
        'adult_visitors',
        'youth_visitors',
        'children_visitors',
        'registered_members_present',
        'total_attendance',
        'notes',
    ];

    protected function casts(): array
    {
        return ['held_at' => 'datetime'];
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'attendance_records')
            ->withPivot(['status', 'checked_in_at', 'notes'])
            ->withTimestamps();
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public const SERVICE_TYPES = [
        'sunday_service' => 'Sunday Service',
        'business_service' => 'Business Service',
        'bible_study' => 'Bible Study',
        'camp_meeting' => 'Camp Meeting',
        'ministry_meeting' => 'Ministry Meeting',
        'special_event' => 'Special Event',
        'other' => 'Other',
    ];
}
