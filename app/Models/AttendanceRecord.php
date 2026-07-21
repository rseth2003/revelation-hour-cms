<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_session_id',
        'member_id',
        'status',
        'checked_in_at',
        'notes',
    ];

    protected function casts(): array
    {
        return ['checked_in_at' => 'datetime'];
    }

    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'attendance_session_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
