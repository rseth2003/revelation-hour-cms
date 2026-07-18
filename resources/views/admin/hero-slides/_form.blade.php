@csrf

<div class="grid gap-8 lg:grid-cols-2">
    <section class="space-y-5">
        <h3 class="text-lg font-bold text-[#072f68]">Slide Content</h3>

        <div>
            <label class="mb-2 block text-sm font-semibold">Title</label>
            <input name="title" value="{{ old('title', $heroSlide->title ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Subtitle</label>
            <input name="subtitle" value="{{ old('subtitle', $heroSlide->subtitle ?? '') }}" class="w-full rounded-xl border-slate-300">
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Description</label>
            <textarea name="description" rows="6" class="w-full rounded-xl border-slate-300">{{ old('description', $heroSlide->description ?? '') }}</textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Background image</label>
            <input type="file" name="background_image" accept=".jpg,.jpeg,.png,.webp" class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-2 text-xs text-slate-500">This becomes the blurred backdrop. The full image is fitted inside the poster frame when no separate poster or video is uploaded.</p>

            @if(isset($heroSlide) && $heroSlide->background_image_url)
                <img src="{{ $heroSlide->background_image_url }}" class="mt-4 h-52 w-full rounded-xl object-contain bg-slate-100">
            @endif
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Optional poster image</label>
            <input type="file" name="poster_image" accept=".jpg,.jpeg,.png,.webp" class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">

            @if(isset($heroSlide) && $heroSlide->poster_image_url)
                <img src="{{ $heroSlide->poster_image_url }}" class="mt-4 h-52 w-full rounded-xl object-contain bg-slate-100">
            @endif
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Optional slide video</label>
            <input type="file" name="video" accept=".mp4,.webm,.mov,video/mp4,video/webm,video/quicktime" class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            <p class="mt-2 text-xs text-slate-500">MP4, WebM, MOV or M4V. Maximum 500 MB. Recommended: MP4 (H.264), 1080p or lower. The video plays muted, loops and fits inside the slide.</p>

            @if(isset($heroSlide) && $heroSlide->video_url)
                <video controls class="mt-4 h-52 w-full rounded-xl bg-black object-contain">
                    <source src="{{ $heroSlide->video_url }}">
                </video>

                <label class="mt-3 flex items-center gap-2 text-sm text-red-700">
                    <input type="checkbox" name="remove_video" value="1">
                    Remove the current video
                </label>
            @endif
        </div>
    </section>

    <section class="space-y-5">
        <h3 class="text-lg font-bold text-[#072f68]">Buttons and Display</h3>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Primary button text</label>
                <input name="primary_button_text" value="{{ old('primary_button_text', $heroSlide->primary_button_text ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold">Primary button link</label>
                <input name="primary_button_url" value="{{ old('primary_button_url', $heroSlide->primary_button_url ?? '') }}" class="w-full rounded-xl border-slate-300" placeholder="/events or https://...">
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Secondary button text</label>
                <input name="secondary_button_text" value="{{ old('secondary_button_text', $heroSlide->secondary_button_text ?? '') }}" class="w-full rounded-xl border-slate-300">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold">Secondary button link</label>
                <input name="secondary_button_url" value="{{ old('secondary_button_url', $heroSlide->secondary_button_url ?? '') }}" class="w-full rounded-xl border-slate-300" placeholder="/contact or https://...">
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Display order</label>
                <input type="number" name="sort_order" min="0" max="9999" value="{{ old('sort_order', $heroSlide->sort_order ?? 0) }}" class="w-full rounded-xl border-slate-300" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold">Overlay opacity</label>
                <input type="number" name="overlay_opacity" min="0" max="90" value="{{ old('overlay_opacity', $heroSlide->overlay_opacity ?? 55) }}" class="w-full rounded-xl border-slate-300" required>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold">Start date and time</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at', isset($heroSlide) && $heroSlide->starts_at ? $heroSlide->starts_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-slate-300">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold">End date and time</label>
                <input type="datetime-local" name="ends_at" value="{{ old('ends_at', isset($heroSlide) && $heroSlide->ends_at ? $heroSlide->ends_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-slate-300">
            </div>
        </div>

        <label class="flex gap-3 rounded-xl border bg-slate-50 p-4">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $heroSlide->is_published ?? false))>
            <span><strong class="block text-sm">Publish slide</strong><span class="text-xs text-slate-500">Only published slides appear on the homepage.</span></span>
        </label>

        <label class="flex gap-3 rounded-xl border bg-slate-50 p-4">
            <input type="checkbox" name="open_links_in_new_tab" value="1" @checked(old('open_links_in_new_tab', $heroSlide->open_links_in_new_tab ?? false))>
            <span><strong class="block text-sm">Open buttons in a new tab</strong></span>
        </label>
    </section>
</div>

@if($errors->any())
<div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
    <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<div class="mt-8 flex gap-3">
    <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button>
    <a href="{{ route('admin.hero-slides.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>
