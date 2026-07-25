<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LibraryCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','description','sort_order','is_published'];

    protected function casts(): array
    {
        return ['sort_order'=>'integer','is_published'=>'boolean'];
    }

    public function resources(): HasMany
    {
        return $this->hasMany(LibraryResource::class);
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'category';
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
