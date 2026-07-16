<x-admin-layout title="Word of the Day | RHMI CMS" heading="Word of the Day">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#072f68]">Word of the Day</h2>
            <p class="mt-1 text-sm text-slate-600">
                Publish daily scripture, devotions, posters and audio messages.
            </p>
        </div>

        <a
            href="{{ route('admin.daily-words.create') }}"
            class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68] shadow hover:bg-lime-400"
        >
            + Add Daily Word
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($words->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <p class="text-lg font-semibold text-[#072f68]">No daily messages yet</p>
            <p class="mt-2 text-sm text-slate-500">Create the first Word of the Day.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($words as $word)
                <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                    @if ($word->poster_url)
                        <img
                            src="{{ $word->poster_url }}"
                            alt="{{ $word->title }}"
                            class="h-52 w-full object-cover"
                        >
                    @else
                        <div class="grid h-52 place-items-center bg-gradient-to-br from-[#072f68] to-[#0d5fa8] p-6 text-center text-xl font-bold text-white">
                            {{ $word->scripture_reference ?: $word->title }}
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h3 class="font-bold text-[#072f68]">{{ $word->title }}</h3>

                            <div class="flex flex-col gap-1 text-right">
                                @if ($word->is_featured)
                                    <span class="rounded-full bg-lime-100 px-2.5 py-1 text-xs font-semibold text-lime-700">
                                        Featured
                                    </span>
                                @endif

                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $word->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $word->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-sm text-slate-500">
                            {{ $word->publish_date->format('j M Y') }}
                        </p>

                        @if ($word->scripture_reference)
                            <p class="mt-2 text-sm font-semibold text-slate-700">
                                {{ $word->scripture_reference }}
                            </p>
                        @endif

                        <div class="mt-5 flex gap-2">
                            <a
                                href="{{ route('admin.daily-words.edit', $word) }}"
                                class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-center text-sm font-semibold text-blue-700 hover:bg-blue-50"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.daily-words.destroy', $word) }}"
                                class="flex-1"
                                onsubmit="return confirm('Delete this Word of the Day permanently?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $words->links() }}
        </div>
    @endif
</x-admin-layout>
