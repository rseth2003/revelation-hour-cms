@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Album title</label>
            <input name="title" value="{{ old('title', $album->title ?? '') }}"
                   class="w-full rounded-xl border-slate-300" required>
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Album description</label>
            <textarea name="description" rows="7"
                      class="w-full rounded-xl border-slate-300">{{ old('description', $album->description ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Album date</label>
                <input type="date" name="album_date"
                       value="{{ old('album_date', isset($album) && $album->album_date ? $album->album_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                       class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Display order</label>
                <input type="number" min="0" name="sort_order"
                       value="{{ old('sort_order', $album->sort_order ?? 0) }}"
                       class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Related ministry</label>
                <select name="ministry_id" class="w-full rounded-xl border-slate-300">
                    <option value="">None</option>
                    @foreach($ministries as $ministry)
                        <option value="{{ $ministry->id }}"
                            @selected((string) old('ministry_id', $album->ministry_id ?? '') === (string) $ministry->id)>
                            {{ $ministry->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Related campus</label>
                <select name="campus_id" class="w-full rounded-xl border-slate-300">
                    <option value="">None</option>
                    @foreach($campuses as $campus)
                        <option value="{{ $campus->id }}"
                            @selected((string) old('campus_id', $album->campus_id ?? '') === (string) $campus->id)>
                            {{ $campus->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Related event</label>
                <select name="event_id" class="w-full rounded-xl border-slate-300">
                    <option value="">None</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}"
                            @selected((string) old('event_id', $album->event_id ?? '') === (string) $event->id)>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Album cover image</label>
            <input type="file" name="cover_image" accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            @if(isset($album) && $album->cover_image_url)
                <img src="{{ $album->cover_image_url }}" alt="{{ $album->title }}"
                     class="mt-4 h-60 w-full rounded-xl object-contain bg-slate-100">
            @endif
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Upload album photos</label>
            <input type="file" name="photos[]" multiple accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-1 text-xs text-slate-500">You can select up to 40 images at once. Maximum 8 MB per image.</p>
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_featured" type="checkbox" value="1"
                   @checked(old('is_featured', $album->is_featured ?? false))>
            <span>
                <strong class="block text-sm">Feature this album</strong>
                <span class="text-xs text-slate-500">The featured album appears first on the public gallery.</span>
            </span>
        </label>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_published" type="checkbox" value="1"
                   @checked(old('is_published', $album->is_published ?? false))>
            <span>
                <strong class="block text-sm">Publish album</strong>
                <span class="text-xs text-slate-500">Published albums are visible on the public website.</span>
            </span>
        </label>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button>
    <a href="{{ route('admin.gallery.index') }}"
       class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">
        Cancel
    </a>
</div>
