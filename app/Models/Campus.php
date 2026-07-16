<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','short_description','description','resident_pastor','pastor_bio',
        'address','district','country','phone_primary','phone_secondary','email',
        'service_times','map_url','cover_image_path','pastor_image_path',
        'is_main_campus','is_published','sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_main_campus' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image_path ? Storage::url($this->cover_image_path) : null;
    }

    public function getPastorImageUrlAttribute(): ?string
    {
        return $this->pastor_image_path ? Storage::url($this->pastor_image_path) : null;
    }
}
