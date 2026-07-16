@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Ministry name</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $ministry->name ?? '') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                   required>
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="short_description" class="mb-2 block text-sm font-semibold text-slate-700">Short description</label>
            <textarea id="short_description" name="short_description" rows="3"
                      class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                      required>{{ old('short_description', $ministry->short_description ?? '') }}</textarea>
            <p class="mt-1 text-xs text-slate-500">Used on ministry cards.</p>
            @error('short_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Full description</label>
            <textarea id="description" name="description" rows="8"
                      class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                      required>{{ old('description', $ministry->description ?? '') }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="leader_name" class="mb-2 block text-sm font-semibold text-slate-700">Leader name</label>
                <input id="leader_name" name="leader_name" type="text"
                       value="{{ old('leader_name', $ministry->leader_name ?? '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('leader_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="meeting_schedule" class="mb-2 block text-sm font-semibold text-slate-700">Meeting schedule</label>
                <input id="meeting_schedule" name="meeting_schedule" type="text"
                       value="{{ old('meeting_schedule', $ministry->meeting_schedule ?? '') }}"
                       placeholder="Example: Saturdays at 4 PM"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('meeting_schedule') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Meeting location</label>
            <input id="location" name="location" type="text"
                   value="{{ old('location', $ministry->location ?? '') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
            @error('location') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-5">
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="contact_phone" class="mb-2 block text-sm font-semibold text-slate-700">Contact phone</label>
                <input id="contact_phone" name="contact_phone" type="text"
                       value="{{ old('contact_phone', $ministry->contact_phone ?? '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('contact_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contact_email" class="mb-2 block text-sm font-semibold text-slate-700">Contact email</label>
                <input id="contact_email" name="contact_email" type="email"
                       value="{{ old('contact_email', $ministry->contact_email ?? '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('contact_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-semibold text-slate-700">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $ministry->sort_order ?? 0) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
            <p class="mt-1 text-xs text-slate-500">Lower numbers appear first.</p>
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="cover_image" class="mb-2 block text-sm font-semibold text-slate-700">Cover image</label>
            <input id="cover_image" name="cover_image" type="file" accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-1 text-xs text-slate-500">Shown on the public ministry card and page.</p>
            @error('cover_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

            @if(isset($ministry) && $ministry->cover_image_url)
                <img src="{{ $ministry->cover_image_url }}" alt="{{ $ministry->name }}"
                     class="mt-4 h-48 w-full rounded-xl object-cover">
            @endif
        </div>

        <div>
            <label for="leader_image" class="mb-2 block text-sm font-semibold text-slate-700">Leader photo</label>
            <input id="leader_image" name="leader_image" type="file" accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            @error('leader_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

            @if(isset($ministry) && $ministry->leader_image_url)
                <img src="{{ $ministry->leader_image_url }}" alt="{{ $ministry->leader_name }}"
                     class="mt-4 h-40 w-40 rounded-xl object-cover">
            @endif
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_published" type="checkbox" value="1"
                   @checked(old('is_published', $ministry->is_published ?? false))
                   class="rounded border-slate-300 text-blue-700 focus:ring-blue-700">
            <span>
                <strong class="block text-sm text-slate-800">Publish ministry</strong>
                <span class="text-xs text-slate-500">Published ministries appear on the public website.</span>
            </span>
        </label>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white hover:bg-blue-900">
        {{ $buttonText }}
    </button>

    <a href="{{ route('admin.ministries.index') }}"
       class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700 hover:bg-slate-50">
        Cancel
    </a>
</div>
