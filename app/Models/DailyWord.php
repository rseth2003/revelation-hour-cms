<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DailyWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'bible_version',
        'bible_book',
        'bible_chapter',
        'bible_verse_start',
        'bible_verse_end',
        'scripture_reference',
        'scripture_text',
        'message',
        'author',
        'publish_date',
        'poster_path',
        'audio_path',
        'is_featured',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',
            'bible_chapter' => 'integer',
            'bible_verse_start' => 'integer',
            'bible_verse_end' => 'integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getPosterUrlAttribute(): ?string
    {
        return $this->poster_path ? Storage::url($this->poster_path) : null;
    }

    public function getAudioUrlAttribute(): ?string
    {
        return $this->audio_path ? Storage::url($this->audio_path) : null;
    }
}
