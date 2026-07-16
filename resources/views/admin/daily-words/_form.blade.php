@csrf

@php
$books = [
    'Genesis'=>50,'Exodus'=>40,'Leviticus'=>27,'Numbers'=>36,'Deuteronomy'=>34,
    'Joshua'=>24,'Judges'=>21,'Ruth'=>4,'1 Samuel'=>31,'2 Samuel'=>24,'1 Kings'=>22,'2 Kings'=>25,
    '1 Chronicles'=>29,'2 Chronicles'=>36,'Ezra'=>10,'Nehemiah'=>13,'Esther'=>10,'Job'=>42,
    'Psalms'=>150,'Proverbs'=>31,'Ecclesiastes'=>12,'Song of Solomon'=>8,'Isaiah'=>66,'Jeremiah'=>52,
    'Lamentations'=>5,'Ezekiel'=>48,'Daniel'=>12,'Hosea'=>14,'Joel'=>3,'Amos'=>9,'Obadiah'=>1,
    'Jonah'=>4,'Micah'=>7,'Nahum'=>3,'Habakkuk'=>3,'Zephaniah'=>3,'Haggai'=>2,'Zechariah'=>14,'Malachi'=>4,
    'Matthew'=>28,'Mark'=>16,'Luke'=>24,'John'=>21,'Acts'=>28,'Romans'=>16,'1 Corinthians'=>16,
    '2 Corinthians'=>13,'Galatians'=>6,'Ephesians'=>6,'Philippians'=>4,'Colossians'=>4,
    '1 Thessalonians'=>5,'2 Thessalonians'=>3,'1 Timothy'=>6,'2 Timothy'=>4,'Titus'=>3,'Philemon'=>1,
    'Hebrews'=>13,'James'=>5,'1 Peter'=>5,'2 Peter'=>3,'1 John'=>5,'2 John'=>1,'3 John'=>1,'Jude'=>1,'Revelation'=>22,
];
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-5">
        <div>
            <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $dailyWord->title ?? '') }}"
                   class="w-full rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600" required>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <section class="rounded-2xl border border-blue-200 bg-blue-50 p-5">
            <div class="mb-4">
                <h3 class="font-bold text-[#072f68]">Bible Scripture Picker</h3>
                <p class="mt-1 text-xs text-slate-600">Choose a translation, book, chapter and verse, then retrieve the Scripture automatically.</p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="bible_version" class="mb-2 block text-sm font-semibold text-slate-700">Bible version</label>
                    <select id="bible_version" name="bible_version" class="w-full rounded-xl border-slate-300">
                        @foreach(['KJV'=>'King James Version','WEB'=>'World English Bible','ASV'=>'American Standard Version','NIV'=>'New International Version','NKJV'=>'New King James Version','ESV'=>'English Standard Version'] as $code => $label)
                            <option value="{{ $code }}" @selected(old('bible_version', $dailyWord->bible_version ?? 'KJV') === $code)>
                                {{ $code }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-slate-500">NIV, NKJV and ESV require licensed API.Bible access.</p>
                </div>

                <div>
                    <label for="bible_book" class="mb-2 block text-sm font-semibold text-slate-700">Book</label>
                    <select id="bible_book" name="bible_book" class="w-full rounded-xl border-slate-300">
                        @foreach($books as $book => $chapters)
                            <option value="{{ $book }}" data-chapters="{{ $chapters }}"
                                @selected(old('bible_book', $dailyWord->bible_book ?? 'John') === $book)>
                                {{ $book }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="bible_chapter" class="mb-2 block text-sm font-semibold text-slate-700">Chapter</label>
                    <select id="bible_chapter" name="bible_chapter" class="w-full rounded-xl border-slate-300"
                            data-selected="{{ old('bible_chapter', $dailyWord->bible_chapter ?? 3) }}"></select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="bible_verse_start" class="mb-2 block text-sm font-semibold text-slate-700">Verse</label>
                        <input id="bible_verse_start" name="bible_verse_start" type="number" min="1" max="176"
                               value="{{ old('bible_verse_start', $dailyWord->bible_verse_start ?? 16) }}"
                               class="w-full rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label for="bible_verse_end" class="mb-2 block text-sm font-semibold text-slate-700">End verse</label>
                        <input id="bible_verse_end" name="bible_verse_end" type="number" min="1" max="176"
                               value="{{ old('bible_verse_end', $dailyWord->bible_verse_end ?? '') }}"
                               class="w-full rounded-xl border-slate-300" placeholder="Optional">
                    </div>
                </div>
            </div>

            <button id="fetchScripture" type="button"
                    class="mt-4 rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white hover:bg-blue-900">
                Get Scripture Text
            </button>

            <p id="bibleLookupStatus" class="mt-3 text-sm font-semibold"></p>
        </section>

        <div>
            <label for="scripture_reference" class="mb-2 block text-sm font-semibold text-slate-700">Scripture reference</label>
            <input id="scripture_reference" name="scripture_reference" type="text"
                   value="{{ old('scripture_reference', $dailyWord->scripture_reference ?? '') }}"
                   class="w-full rounded-xl border-slate-300">
        </div>

        <div>
            <label for="scripture_text" class="mb-2 block text-sm font-semibold text-slate-700">Scripture text</label>
            <textarea id="scripture_text" name="scripture_text" rows="6"
                      class="w-full rounded-xl border-slate-300">{{ old('scripture_text', $dailyWord->scripture_text ?? '') }}</textarea>
        </div>

        <div>
            <label for="message" class="mb-2 block text-sm font-semibold text-slate-700">Daily message or devotion</label>
            <textarea id="message" name="message" rows="9"
                      class="w-full rounded-xl border-slate-300">{{ old('message', $dailyWord->message ?? '') }}</textarea>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="author" class="mb-2 block text-sm font-semibold text-slate-700">Author or speaker</label>
                <input id="author" name="author" type="text" value="{{ old('author', $dailyWord->author ?? '') }}"
                       class="w-full rounded-xl border-slate-300">
            </div>
            <div>
                <label for="publish_date" class="mb-2 block text-sm font-semibold text-slate-700">Publish date</label>
                <input id="publish_date" name="publish_date" type="date"
                       value="{{ old('publish_date', isset($dailyWord) && $dailyWord->publish_date ? $dailyWord->publish_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                       class="w-full rounded-xl border-slate-300" required>
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <div>
            <label for="poster" class="mb-2 block text-sm font-semibold text-slate-700">Poster image</label>
            <input id="poster" name="poster" type="file" accept=".jpg,.jpeg,.png,.webp"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            @if(isset($dailyWord) && $dailyWord->poster_url)
                <img src="{{ $dailyWord->poster_url }}" alt="{{ $dailyWord->title }}"
                     class="mt-4 h-64 w-full rounded-xl bg-slate-100 object-contain">
            @endif
        </div>

        <div>
            <label for="audio" class="mb-2 block text-sm font-semibold text-slate-700">Audio message</label>
            <input id="audio" name="audio" type="file" accept=".mp3,.m4a,.wav,.ogg"
                   class="block w-full rounded-xl border border-slate-300 bg-white p-3 text-sm">
            @if(isset($dailyWord) && $dailyWord->audio_url)
                <audio controls class="mt-4 w-full"><source src="{{ $dailyWord->audio_url }}"></audio>
            @endif
        </div>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_featured" type="checkbox" value="1"
                   @checked(old('is_featured', $dailyWord->is_featured ?? false))
                   class="rounded border-slate-300 text-blue-700">
            <span><strong class="block text-sm text-slate-800">Feature this message</strong><span class="text-xs text-slate-500">Show it on the homepage.</span></span>
        </label>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
            <input name="is_published" type="checkbox" value="1"
                   @checked(old('is_published', $dailyWord->is_published ?? false))
                   class="rounded border-slate-300 text-blue-700">
            <span><strong class="block text-sm text-slate-800">Publish message</strong><span class="text-xs text-slate-500">Make it visible publicly.</span></span>
        </label>
    </div>
</div>

<div class="mt-8 flex gap-3">
    <button type="submit" class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">{{ $buttonText }}</button>
    <a href="{{ route('admin.daily-words.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const book = document.getElementById('bible_book');
    const chapter = document.getElementById('bible_chapter');
    const button = document.getElementById('fetchScripture');
    const status = document.getElementById('bibleLookupStatus');

    function fillChapters() {
        const count = Number(book.options[book.selectedIndex].dataset.chapters || 1);
        const selected = Number(chapter.dataset.selected || chapter.value || 1);
        chapter.innerHTML = '';
        for (let number = 1; number <= count; number++) {
            const option = document.createElement('option');
            option.value = number;
            option.textContent = number;
            if (number === Math.min(selected, count)) option.selected = true;
            chapter.appendChild(option);
        }
        chapter.dataset.selected = '';
    }

    book.addEventListener('change', fillChapters);
    fillChapters();

    button.addEventListener('click', async () => {
        status.textContent = 'Retrieving Scripture...';
        status.className = 'mt-3 text-sm font-semibold text-blue-700';
        button.disabled = true;

        const params = new URLSearchParams({
            version: document.getElementById('bible_version').value,
            book: book.value,
            chapter: chapter.value,
            verse_start: document.getElementById('bible_verse_start').value,
            verse_end: document.getElementById('bible_verse_end').value,
        });

        try {
            const response = await fetch(`{{ route('admin.bible.lookup') }}?${params.toString()}`, {
                headers: { 'Accept': 'application/json' },
            });
            const result = await response.json();

            if (!response.ok) throw new Error(result.message || 'Scripture lookup failed.');

            document.getElementById('scripture_reference').value = result.reference;
            document.getElementById('scripture_text').value = result.text;
            status.textContent = 'Scripture added successfully.';
            status.className = 'mt-3 text-sm font-semibold text-green-700';
        } catch (error) {
            status.textContent = error.message;
            status.className = 'mt-3 text-sm font-semibold text-red-700';
        } finally {
            button.disabled = false;
        }
    });
});
</script>
