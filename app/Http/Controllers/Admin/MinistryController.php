<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MinistryController extends Controller
{
    public function index(): View
    {
        $ministries = Ministry::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.ministries.index', compact('ministries'));
    }

    public function create(): View
    {
        return view('admin.ministries.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('ministries/covers', 'public');
        }

        if ($request->hasFile('leader_image')) {
            $data['leader_image_path'] = $request->file('leader_image')->store('ministries/leaders', 'public');
        }

        Ministry::create($data);

        return redirect()
            ->route('admin.ministries.index')
            ->with('success', 'Ministry created successfully.');
    }

    public function edit(Ministry $ministry): View
    {
        return view('admin.ministries.edit', compact('ministry'));
    }

    public function update(Request $request, Ministry $ministry): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $ministry->id);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            if ($ministry->cover_image_path) {
                Storage::disk('public')->delete($ministry->cover_image_path);
            }

            $data['cover_image_path'] = $request->file('cover_image')->store('ministries/covers', 'public');
        }

        if ($request->hasFile('leader_image')) {
            if ($ministry->leader_image_path) {
                Storage::disk('public')->delete($ministry->leader_image_path);
            }

            $data['leader_image_path'] = $request->file('leader_image')->store('ministries/leaders', 'public');
        }

        $ministry->update($data);

        return redirect()
            ->route('admin.ministries.index')
            ->with('success', 'Ministry updated successfully.');
    }

    public function destroy(Ministry $ministry): RedirectResponse
    {
        if ($ministry->cover_image_path) {
            Storage::disk('public')->delete($ministry->cover_image_path);
        }

        if ($ministry->leader_image_path) {
            Storage::disk('public')->delete($ministry->leader_image_path);
        }

        $ministry->delete();

        return redirect()
            ->route('admin.ministries.index')
            ->with('success', 'Ministry deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'short_description' => ['required', 'string', 'max:300'],
            'description' => ['required', 'string', 'max:6000'],
            'leader_name' => ['nullable', 'string', 'max:150'],
            'meeting_schedule' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'leader_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_published' => ['nullable', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $counter = 2;

        while (
            Ministry::query()
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
