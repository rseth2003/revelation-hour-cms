<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Livestream extends Model
{
    use HasFactory;

    public const PLATFORMS = [
        'youtube' => 'YouTube Live',
        'facebook' => 'Facebook Live',
        'zoom' => 'Zoom',
        'custom' => 'Custom Link',
    ];

    protected $fillable = [
        'title','slug','subtitle','speaker','series','description','platform','stream_url',
        'thumbnail_path','scheduled_start','scheduled_end','manual_status','is_featured',
        'show_on_homepage','is_published','sort_order',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_start'=>'datetime','scheduled_end'=>'datetime','is_featured'=>'boolean',
            'show_on_homepage'=>'boolean','is_published'=>'boolean','sort_order'=>'integer',
        ];
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? Storage::disk('public')->url($this->thumbnail_path) : null;
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_published) return 'draft';
        if (in_array($this->manual_status, ['live','ended'], true)) return $this->manual_status;
        if ($this->scheduled_start && now()->lt($this->scheduled_start)) return 'upcoming';
        if ($this->scheduled_end && now()->gte($this->scheduled_end)) return 'ended';
        if ($this->scheduled_start && now()->gte($this->scheduled_start)) return 'live';
        return 'upcoming';
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if (!$this->stream_url) return null;
        if ($this->platform === 'youtube' && preg_match('~(?:youtu\\.be/|youtube\\.com/(?:watch\\?v=|embed/|live/|shorts/))([\\w-]{6,})~', $this->stream_url, $m)) return 'https://www.youtube.com/embed/'.$m[1].'?rel=0';
        if ($this->platform === 'facebook') return 'https://www.facebook.com/plugins/video.php?href='.urlencode($this->stream_url).'&show_text=false&width=1280';
        return null;
    }

    public static function uniqueSlug(string $title, ?int $ignoreId=null): string
    {
        $base=Str::slug($title) ?: 'broadcast'; $slug=$base; $n=2;
        while(static::query()->when($ignoreId,fn($q)=>$q->whereKeyNot($ignoreId))->where('slug',$slug)->exists()) $slug=$base.'-'.$n++;
        return $slug;
    }
}
