<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use App\Models\Ministry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryAlbumController extends Controller
{
    public function index(): View
    {
        $albums = GalleryAlbum::query()
            ->withCount('images')
            ->with(['ministry', 'campus', 'event'])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('album_date')
            ->paginate(12);

        return view('admin.gallery.index', compact('albums'));
    }

    public function create(): View
    {
        return view('admin.gallery.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        if ($data['is_featured']) {
            GalleryAlbum::query()->update(['is_featured' => false]);
        }

        $album = GalleryAlbum::create($data);
        $this->storeImages($request, $album);

        return redirect()
            ->route('admin.gallery.edit', $album)
            ->with('success', 'Gallery album created successfully.');
    }

    public function edit(GalleryAlbum $gallery): View
    {
        $gallery->load(['images', 'ministry', 'campus', 'event']);

        return view('admin.gallery.edit', array_merge(
            ['album' => $gallery],
            $this->formData()
        ));
    }

    public function update(Request $request, GalleryAlbum $gallery): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $gallery->id);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image_path) {
                Storage::disk('public')->delete($gallery->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        if ($data['is_featured']) {
            GalleryAlbum::query()->whereKeyNot($gallery->id)->update(['is_featured' => false]);
        }

        $gallery->update($data);
        $this->storeImages($request, $gallery);

        return redirect()
            ->route('admin.gallery.edit', $gallery)
            ->with('success', 'Gallery album updated successfully.');
    }

    public function destroy(GalleryAlbum $gallery): RedirectResponse
    {
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        if ($gallery->cover_image_path) {
            Storage::disk('public')->delete($gallery->cover_image_path);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery album deleted successfully.');
    }

    public function destroyImage(GalleryAlbum $gallery, GalleryImage $image): RedirectResponse
    {
        abort_unless($image->gallery_album_id === $gallery->id, 404);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()
            ->route('admin.gallery.edit', $gallery)
            ->with('success', 'Gallery image deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:8000'],
            'album_date' => ['nullable', 'date_format:Y-m-d'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'photos' => ['nullable', 'array', 'max:40'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'ministry_id' => ['nullable', 'exists:ministries,id'],
            'campus_id' => ['nullable', 'exists:campuses,id'],
            'event_id' => ['nullable', 'exists:events,id'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    private function storeImages(Request $request, GalleryAlbum $album): void
    {
        if (!$request->hasFile('photos')) {
            return;
        }

        $nextOrder = (int) $album->images()->max('sort_order') + 1;

        foreach ($request->file('photos') as $photo) {
            GalleryImage::create([
                'gallery_album_id' => $album->id,
                'image_path' => $photo->store('gallery/albums/'.$album->id, 'public'),
                'sort_order' => $nextOrder++,
            ]);
        }
    }

    private function formData(): array
    {
        return [
            'ministries' => Ministry::query()->orderBy('name')->get(),
            'campuses' => Campus::query()->orderByDesc('is_main_campus')->orderBy('name')->get(),
            'events' => Event::query()->orderByDesc('event_date')->orderBy('title')->get(),
        ];
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'album';
        $slug = $base;
        $counter = 2;

        while (
            GalleryAlbum::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
