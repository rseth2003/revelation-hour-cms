<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sermon extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'speaker',
        'series',
        'bible_passage',
        'description',
        'youtube_url',
        'audio_path',
        'notes_path',
        'thumbnail_path',
        'sermon_date',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sermon_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path
            ? Storage::url($this->thumbnail_path)
            : null;
    }

    public function getAudioUrlAttribute(): ?string
    {
        return $this->audio_path
            ? Storage::url($this->audio_path)
            : null;
    }

    public function getNotesUrlAttribute(): ?string
    {
        return $this->notes_path
            ? Storage::url($this->notes_path)
            : null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_url) {
            return null;
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([\w-]{6,})~', $this->youtube_url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return null;
    }
}
