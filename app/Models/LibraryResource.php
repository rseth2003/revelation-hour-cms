<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LibraryResource extends Model
{
    use HasFactory;

    public const TYPES = [
        'book'=>'Book',
        'bible_study'=>'Bible Study',
        'sermon_notes'=>'Sermon Notes',
        'magazine'=>'Magazine',
        'article'=>'Article',
        'other'=>'Other',
    ];

    protected $fillable = [
        'library_category_id','title','slug','author','resource_type','description',
        'cover_path','file_path','price_ugx','is_paid','allow_read_online',
        'allow_download','is_featured','is_published','sort_order','published_at',
        'view_count','download_count',
    ];

    protected function casts(): array
    {
        return [
            'price_ugx'=>'integer','is_paid'=>'boolean','allow_read_online'=>'boolean',
            'allow_download'=>'boolean','is_featured'=>'boolean','is_published'=>'boolean',
            'sort_order'=>'integer','published_at'=>'datetime','view_count'=>'integer',
            'download_count'=>'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LibraryCategory::class, 'library_category_id');
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path ? Storage::disk('public')->url($this->cover_path) : null;
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'resource';
        $slug = $base;
        $number = 2;

        while (static::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$number++;
        }

        return $slug;
    }
}
