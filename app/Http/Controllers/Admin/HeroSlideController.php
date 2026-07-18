<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        $slides = HeroSlide::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_published'] = $request->boolean('is_published');
        $data['open_links_in_new_tab'] = $request->boolean('open_links_in_new_tab');

        if ($request->hasFile('background_image')) {
            $data['background_image_path'] = $request->file('background_image')
                ->store('hero-slides/backgrounds', 'public');
        }

        if ($request->hasFile('poster_image')) {
            $data['poster_image_path'] = $request->file('poster_image')
                ->store('hero-slides/posters', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video_path'] = $request->file('video')
                ->store('hero-slides/videos', 'public');
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide created successfully.');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_published'] = $request->boolean('is_published');
        $data['open_links_in_new_tab'] = $request->boolean('open_links_in_new_tab');

        if ($request->hasFile('background_image')) {
            if ($heroSlide->background_image_path) {
                Storage::disk('public')->delete($heroSlide->background_image_path);
            }
            $data['background_image_path'] = $request->file('background_image')
                ->store('hero-slides/backgrounds', 'public');
        }

        if ($request->hasFile('poster_image')) {
            if ($heroSlide->poster_image_path) {
                Storage::disk('public')->delete($heroSlide->poster_image_path);
            }
            $data['poster_image_path'] = $request->file('poster_image')
                ->store('hero-slides/posters', 'public');
        }

        if ($request->hasFile('video')) {
            if ($heroSlide->video_path) {
                Storage::disk('public')->delete($heroSlide->video_path);
            }
            $data['video_path'] = $request->file('video')
                ->store('hero-slides/videos', 'public');
        }

        if ($request->boolean('remove_video') && $heroSlide->video_path) {
            Storage::disk('public')->delete($heroSlide->video_path);
            $data['video_path'] = null;
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        foreach ([
            $heroSlide->background_image_path,
            $heroSlide->poster_image_path,
            $heroSlide->video_path,
        ] as $path) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Hero slide deleted.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:1200'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'poster_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'video' => ['nullable', 'file', 'mimes:mp4,webm,mov,m4v', 'max:512000'],
            'remove_video' => ['nullable', 'boolean'],
            'primary_button_text' => ['nullable', 'string', 'max:80'],
            'primary_button_url' => ['nullable', 'string', 'max:500'],
            'secondary_button_text' => ['nullable', 'string', 'max:80'],
            'secondary_button_url' => ['nullable', 'string', 'max:500'],
            'overlay_opacity' => ['required', 'integer', 'min:0', 'max:90'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_published' => ['nullable', 'boolean'],
            'open_links_in_new_tab' => ['nullable', 'boolean'],
        ]);
    }
}
