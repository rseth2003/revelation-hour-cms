<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class PraiseReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'person_name', 'category', 'summary', 'testimony',
        'scripture_reference', 'scripture_text', 'photo_path', 'video_path',
        'video_url', 'audio_path', 'testimony_date', 'status', 'is_featured',
        'show_on_homepage', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'testimony_date' => 'date',
            'is_featured' => 'boolean',
            'show_on_homepage' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(PraiseReportReaction::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PraiseReportComment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->comments()->where('status', 'approved')->oldest();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeForHomepage(Builder $query): Builder
    {
        return $query->published()->where('show_on_homepage', true);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? Storage::url($this->photo_path) : null;
    }

    /**
     * Return the uploaded video URL when a file exists, otherwise return the
     * external video link stored in the video_url database column.
     *
     * The $value argument is essential: referring to $this->video_url from
     * inside this accessor recursively calls the accessor and caused the edit
     * page's "Undefined property" error.
     */
    public function getVideoUrlAttribute(?string $value): ?string
    {
        return $this->video_path ? Storage::url($this->video_path) : $value;
    }

    public function getAudioUrlAttribute(): ?string
    {
        return $this->audio_path ? Storage::url($this->audio_path) : null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $externalUrl = $this->getRawOriginal('video_url');

        if (! $externalUrl) {
            return null;
        }

        if (preg_match(
            '~(?:youtu\\.be/|youtube\\.com/(?:watch\\?v=|embed/|shorts/))([\\w-]{6,})~',
            $externalUrl,
            $matches
        )) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return null;
    }
}
