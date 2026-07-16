<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sermon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SermonController extends Controller
{
    public function index(): View
    {
        $sermons = Sermon::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('sermon_date')
            ->paginate(12);

        return view('admin.sermons.index', compact('sermons'));
    }

    public function create(): View
    {
        return view('admin.sermons.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        $this->storeUploads($request, $data);

        if ($data['is_featured']) {
            Sermon::query()->update(['is_featured' => false]);
        }

        Sermon::create($data);

        return redirect()
            ->route('admin.sermons.index')
            ->with('success', 'Sermon created successfully.');
    }

    public function edit(Sermon $sermon): View
    {
        return view('admin.sermons.edit', compact('sermon'));
    }

    public function update(Request $request, Sermon $sermon): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $sermon->id);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        $this->storeUploads($request, $data, $sermon);

        if ($data['is_featured']) {
            Sermon::query()->whereKeyNot($sermon->id)->update(['is_featured' => false]);
        }

        $sermon->update($data);

        return redirect()
            ->route('admin.sermons.index')
            ->with('success', 'Sermon updated successfully.');
    }

    public function destroy(Sermon $sermon): RedirectResponse
    {
        foreach (['thumbnail_path', 'audio_path', 'notes_path'] as $field) {
            if ($sermon->{$field}) {
                Storage::disk('public')->delete($sermon->{$field});
            }
        }

        $sermon->delete();

        return redirect()
            ->route('admin.sermons.index')
            ->with('success', 'Sermon deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'speaker' => ['nullable', 'string', 'max:150'],
            'series' => ['nullable', 'string', 'max:150'],
            'bible_passage' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:6000'],
            'youtube_url' => ['nullable', 'url', 'max:500'],
            'sermon_date' => ['nullable', 'date_format:Y-m-d'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'audio' => ['nullable', 'file', 'mimes:mp3,m4a,wav,ogg', 'max:51200'],
            'notes' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    private function storeUploads(Request $request, array &$data, ?Sermon $sermon = null): void
    {
        $map = [
            'thumbnail' => ['field' => 'thumbnail_path', 'directory' => 'sermons/thumbnails'],
            'audio' => ['field' => 'audio_path', 'directory' => 'sermons/audio'],
            'notes' => ['field' => 'notes_path', 'directory' => 'sermons/notes'],
        ];

        foreach ($map as $input => $config) {
            if (!$request->hasFile($input)) {
                continue;
            }

            if ($sermon && $sermon->{$config['field']}) {
                Storage::disk('public')->delete($sermon->{$config['field']});
            }

            $data[$config['field']] = $request->file($input)->store($config['directory'], 'public');
        }
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'sermon';
        $slug = $base;
        $counter = 2;

        while (
            Sermon::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
