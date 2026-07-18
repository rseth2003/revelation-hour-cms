<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'background_image_path',
        'poster_image_path',
        'video_path',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'open_links_in_new_tab',
        'overlay_opacity',
        'sort_order',
        'is_published',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'open_links_in_new_tab' => 'boolean',
            'is_published' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function getBackgroundImageUrlAttribute(): ?string
    {
        return $this->background_image_path
            ? Storage::disk('public')->url($this->background_image_path)
            : null;
    }

    public function getPosterImageUrlAttribute(): ?string
    {
        return $this->poster_image_path
            ? Storage::disk('public')->url($this->poster_image_path)
            : null;
    }

    public function getVideoUrlAttribute(): ?string
    {
        return $this->video_path
            ? Storage::disk('public')->url($this->video_path)
            : null;
    }

    public function scopeVisible($query)
    {
        return $query
            ->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }
}
