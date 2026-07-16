<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyWord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DailyWordController extends Controller
{
    public function index(): View
    {
        $words = DailyWord::query()
            ->orderByDesc('is_featured')
            ->orderByDesc('publish_date')
            ->paginate(12);

        return view('admin.daily-words.index', compact('words'));
    }

    public function create(): View
    {
        return view('admin.daily-words.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        $this->storeUploads($request, $data);

        if ($data['is_featured']) {
            DailyWord::query()->update(['is_featured' => false]);
        }

        DailyWord::create($data);

        return redirect()
            ->route('admin.daily-words.index')
            ->with('success', 'Word of the Day created successfully.');
    }

    public function edit(DailyWord $dailyWord): View
    {
        return view('admin.daily-words.edit', compact('dailyWord'));
    }

    public function update(Request $request, DailyWord $dailyWord): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        $this->storeUploads($request, $data, $dailyWord);

        if ($data['is_featured']) {
            DailyWord::query()->whereKeyNot($dailyWord->id)->update(['is_featured' => false]);
        }

        $dailyWord->update($data);

        return redirect()
            ->route('admin.daily-words.index')
            ->with('success', 'Word of the Day updated successfully.');
    }

    public function destroy(DailyWord $dailyWord): RedirectResponse
    {
        foreach (['poster_path', 'audio_path'] as $field) {
            if ($dailyWord->{$field}) {
                Storage::disk('public')->delete($dailyWord->{$field});
            }
        }

        $dailyWord->delete();

        return redirect()
            ->route('admin.daily-words.index')
            ->with('success', 'Word of the Day deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'bible_version' => ['nullable', 'string', 'max:30'],
            'bible_book' => ['nullable', 'string', 'max:80'],
            'bible_chapter' => ['nullable', 'integer', 'min:1', 'max:150'],
            'bible_verse_start' => ['nullable', 'integer', 'min:1', 'max:176'],
            'bible_verse_end' => ['nullable', 'integer', 'min:1', 'max:176'],
            'scripture_reference' => ['nullable', 'string', 'max:180'],
            'scripture_text' => ['nullable', 'string', 'max:4000'],
            'message' => ['nullable', 'string', 'max:8000'],
            'author' => ['nullable', 'string', 'max:150'],
            'publish_date' => ['required', 'date_format:Y-m-d'],
            'poster' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'audio' => ['nullable', 'file', 'mimes:mp3,m4a,wav,ogg', 'max:51200'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    private function storeUploads(Request $request, array &$data, ?DailyWord $dailyWord = null): void
    {
        foreach ([
            'poster' => ['poster_path', 'daily-words/posters'],
            'audio' => ['audio_path', 'daily-words/audio'],
        ] as $input => [$field, $directory]) {
            if (!$request->hasFile($input)) {
                continue;
            }

            if ($dailyWord && $dailyWord->{$field}) {
                Storage::disk('public')->delete($dailyWord->{$field});
            }

            $data[$field] = $request->file($input)->store($directory, 'public');
        }
    }
}
