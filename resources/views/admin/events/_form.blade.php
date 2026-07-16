@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Event title</label>
            <input id="title" name="title" type="text"
                   value="{{ old('title', $event->title ?? '') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                   required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
            <textarea id="description" name="description" rows="6"
                      class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">{{ old('description', $event->description ?? '') }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Location</label>
            <input id="location" name="location" type="text"
                   value="{{ old('location', $event->location ?? '') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-5">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="event_day" class="mb-2 block text-sm font-semibold text-slate-700">Event date</label>
                <input id="event_day" name="event_day" type="date"
                       value="{{ old('event_day', isset($event) && $event->event_date ? $event->event_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('event_day') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="event_time" class="mb-2 block text-sm font-semibold text-slate-700">Event time</label>
                <input id="event_time" name="event_time" type="time"
                       value="{{ old('event_time', isset($event) && $event->event_date ? $event->event_date->format('H:i') : '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                <p class="mt-1 text-xs text-slate-500">Optional. Leave blank for an all-day event.</p>
                @error('event_time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-semibold text-slate-700">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $event->sort_order ?? 0) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
            <p class="mt-1 text-xs text-slate-500">Lower numbers appear first.</p>
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="poster" class="mb-2 block text-sm font-semibold text-slate-700">Poster image</label>
            <input id="poster" name="poster" type="file" accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-1 text-xs text-slate-500">JPG, PNG or WebP. Maximum 5 MB.</p>
            @error('poster') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

            @if(isset($event) && $event->poster_url)
                <img src="{{ $event->poster_url }}" alt="{{ $event->title }}"
                     class="mt-4 h-48 w-full rounded-xl object-cover">
            @endif
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_published" type="checkbox" value="1"
                   @checked(old('is_published', $event->is_published ?? false))
                   class="rounded border-slate-300 text-blue-700 focus:ring-blue-700">
            <span>
                <strong class="block text-sm text-slate-800">Publish event</strong>
                <span class="text-xs text-slate-500">Published events will later appear on the public homepage.</span>
            </span>
        </label>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white hover:bg-blue-900">
        {{ $buttonText }}
    </button>
    <a href="{{ route('admin.events.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700 hover:bg-slate-50">
        Cancel
    </a>
</div>
