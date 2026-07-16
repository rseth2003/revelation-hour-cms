<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChurchService extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'service_type',
        'campus_id',
        'service_date',
        'start_time',
        'end_time',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
        ];
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public const TYPES = [
        'sunday_service' => 'Sunday Service',
        'bible_study' => 'Bible Study',
        'prayer_meeting' => 'Prayer Meeting',
        'camp_meeting' => 'Camp Meeting',
        'youth_service' => 'Youth Service',
        'women_service' => 'Women Service',
        'men_service' => 'Men Service',
        'special_event' => 'Special Event',
        'other' => 'Other',
    ];

    public const STATUSES = [
        'open' => 'Open',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];
}
