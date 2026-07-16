<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ministry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'leader_name',
        'meeting_schedule',
        'location',
        'contact_phone',
        'contact_email',
        'cover_image_path',
        'leader_image_path',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image_path
            ? Storage::url($this->cover_image_path)
            : null;
    }

    public function getLeaderImageUrlAttribute(): ?string
    {
        return $this->leader_image_path
            ? Storage::url($this->leader_image_path)
            : null;
    }
}
