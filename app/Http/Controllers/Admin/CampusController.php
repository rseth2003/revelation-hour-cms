<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CampusController extends Controller
{
    public function index(): View
    {
        $campuses = Campus::query()
            ->orderByDesc('is_main_campus')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.campuses.index', compact('campuses'));
    }

    public function create(): View
    {
        return view('admin.campuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_main_campus'] = $request->boolean('is_main_campus');
        $data['is_published'] = $request->boolean('is_published');
        $this->storeUploads($request, $data);

        if ($data['is_main_campus']) {
            Campus::query()->update(['is_main_campus' => false]);
        }

        Campus::create($data);

        return redirect()->route('admin.campuses.index')->with('success', 'Campus created successfully.');
    }

    public function edit(Campus $campus): View
    {
        return view('admin.campuses.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $campus->id);
        $data['is_main_campus'] = $request->boolean('is_main_campus');
        $data['is_published'] = $request->boolean('is_published');
        $this->storeUploads($request, $data, $campus);

        if ($data['is_main_campus']) {
            Campus::query()->whereKeyNot($campus->id)->update(['is_main_campus' => false]);
        }

        $campus->update($data);

        return redirect()->route('admin.campuses.index')->with('success', 'Campus updated successfully.');
    }

    public function destroy(Campus $campus): RedirectResponse
    {
        foreach (['cover_image_path', 'pastor_image_path'] as $field) {
            if ($campus->{$field}) {
                Storage::disk('public')->delete($campus->{$field});
            }
        }

        $campus->delete();

        return redirect()->route('admin.campuses.index')->with('success', 'Campus deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required','string','max:180'],
            'short_description' => ['nullable','string','max:350'],
            'description' => ['nullable','string','max:8000'],
            'resident_pastor' => ['nullable','string','max:180'],
            'pastor_bio' => ['nullable','string','max:4000'],
            'address' => ['required','string','max:350'],
            'district' => ['nullable','string','max:150'],
            'country' => ['required','string','max:100'],
            'phone_primary' => ['nullable','string','max:50'],
            'phone_secondary' => ['nullable','string','max:50'],
            'email' => ['nullable','email','max:180'],
            'service_times' => ['nullable','string','max:3000'],
            'map_url' => ['nullable','url','max:1000'],
            'cover_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:8192'],
            'pastor_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
            'sort_order' => ['nullable','integer','min:0','max:9999'],
            'is_main_campus' => ['nullable','boolean'],
            'is_published' => ['nullable','boolean'],
        ]);
    }

    private function storeUploads(Request $request, array &$data, ?Campus $campus = null): void
    {
        foreach ([
            'cover_image' => ['cover_image_path', 'campuses/covers'],
            'pastor_image' => ['pastor_image_path', 'campuses/pastors'],
        ] as $input => [$field, $directory]) {
            if (!$request->hasFile($input)) continue;

            if ($campus && $campus->{$field}) {
                Storage::disk('public')->delete($campus->{$field});
            }

            $data[$field] = $request->file($input)->store($directory, 'public');
        }
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'campus';
        $slug = $base;
        $counter = 2;

        while (Campus::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
