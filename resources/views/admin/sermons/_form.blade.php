@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Sermon title</label>
            <input id="title" name="title" type="text"
                   value="{{ old('title', $sermon->title ?? '') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                   required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="speaker" class="mb-2 block text-sm font-semibold text-slate-700">Speaker</label>
                <input id="speaker" name="speaker" type="text"
                       value="{{ old('speaker', $sermon->speaker ?? '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('speaker') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="series" class="mb-2 block text-sm font-semibold text-slate-700">Series</label>
                <input id="series" name="series" type="text"
                       value="{{ old('series', $sermon->series ?? '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('series') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="bible_passage" class="mb-2 block text-sm font-semibold text-slate-700">Bible passage</label>
                <input id="bible_passage" name="bible_passage" type="text"
                       value="{{ old('bible_passage', $sermon->bible_passage ?? '') }}"
                       placeholder="Example: John 3:16"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('bible_passage') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="sermon_date" class="mb-2 block text-sm font-semibold text-slate-700">Sermon date</label>
                <input id="sermon_date" name="sermon_date" type="date"
                       value="{{ old('sermon_date', isset($sermon) && $sermon->sermon_date ? $sermon->sermon_date->format('Y-m-d') : '') }}"
                       class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
                @error('sermon_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
            <textarea id="description" name="description" rows="8"
                      class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">{{ old('description', $sermon->description ?? '') }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="youtube_url" class="mb-2 block text-sm font-semibold text-slate-700">YouTube URL</label>
            <input id="youtube_url" name="youtube_url" type="url"
                   value="{{ old('youtube_url', $sermon->youtube_url ?? '') }}"
                   placeholder="https://youtube.com/watch?v=..."
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
            @error('youtube_url') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-5">
        <div>
            <label for="thumbnail" class="mb-2 block text-sm font-semibold text-slate-700">Thumbnail image</label>
            <input id="thumbnail" name="thumbnail" type="file" accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            @error('thumbnail') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

            @if(isset($sermon) && $sermon->thumbnail_url)
                <img src="{{ $sermon->thumbnail_url }}" alt="{{ $sermon->title }}"
                     class="mt-4 h-48 w-full rounded-xl object-cover">
            @endif
        </div>

        <div>
            <label for="audio" class="mb-2 block text-sm font-semibold text-slate-700">Audio file</label>
            <input id="audio" name="audio" type="file" accept=".mp3,.m4a,.wav,.ogg"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-1 text-xs text-slate-500">Maximum 50 MB.</p>
            @error('audio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

            @if(isset($sermon) && $sermon->audio_url)
                <audio controls class="mt-4 w-full">
                    <source src="{{ $sermon->audio_url }}">
                </audio>
            @endif
        </div>

        <div>
            <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">Sermon notes</label>
            <input id="notes" name="notes" type="file" accept=".pdf,.doc,.docx"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-1 text-xs text-slate-500">PDF, DOC or DOCX. Maximum 10 MB.</p>
            @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-2 block text-sm font-semibold text-slate-700">Display order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $sermon->sort_order ?? 0) }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
            @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_featured" type="checkbox" value="1"
                   @checked(old('is_featured', $sermon->is_featured ?? false))
                   class="rounded border-slate-300 text-blue-700 focus:ring-blue-700">
            <span>
                <strong class="block text-sm text-slate-800">Feature this sermon</strong>
                <span class="text-xs text-slate-500">The featured sermon appears on the homepage.</span>
            </span>
        </label>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_published" type="checkbox" value="1"
                   @checked(old('is_published', $sermon->is_published ?? false))
                   class="rounded border-slate-300 text-blue-700 focus:ring-blue-700">
            <span>
                <strong class="block text-sm text-slate-800">Publish sermon</strong>
                <span class="text-xs text-slate-500">Published sermons appear on the public website.</span>
            </span>
        </label>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white hover:bg-blue-900">
        {{ $buttonText }}
    </button>

    <a href="{{ route('admin.sermons.index') }}"
       class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700 hover:bg-slate-50">
        Cancel
    </a>
</div>
