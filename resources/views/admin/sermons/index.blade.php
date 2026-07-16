<x-admin-layout title="Sermons | RHMI CMS" heading="Sermons">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#072f68]">Sermons</h2>
            <p class="mt-1 text-sm text-slate-600">Manage video, audio, sermon notes and featured messages.</p>
        </div>

        <a href="{{ route('admin.sermons.create') }}"
           class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68] shadow hover:bg-lime-400">
            + Add Sermon
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($sermons->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <p class="text-lg font-semibold text-[#072f68]">No sermons yet</p>
            <p class="mt-2 text-sm text-slate-500">Add your first sermon and publish it to the website.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($sermons as $sermon)
                <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                    @if($sermon->thumbnail_url)
                        <img src="{{ $sermon->thumbnail_url }}" alt="{{ $sermon->title }}" class="h-52 w-full object-cover">
                    @else
                        <div class="grid h-52 place-items-center bg-gradient-to-br from-[#072f68] to-[#0d5fa8] text-4xl text-white">▶</div>
                    @endif

                    <div class="p-5">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h3 class="font-bold text-[#072f68]">{{ $sermon->title }}</h3>

                            <div class="flex flex-col gap-1 text-right">
                                @if($sermon->is_featured)
                                    <span class="rounded-full bg-lime-100 px-2.5 py-1 text-xs font-semibold text-lime-700">Featured</span>
                                @endif

                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $sermon->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $sermon->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        @if($sermon->speaker)
                            <p class="text-sm text-slate-600">{{ $sermon->speaker }}</p>
                        @endif

                        @if($sermon->sermon_date)
                            <p class="mt-1 text-sm text-slate-500">{{ $sermon->sermon_date->format('j M Y') }}</p>
                        @endif

                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('admin.sermons.edit', $sermon) }}"
                               class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-center text-sm font-semibold text-blue-700 hover:bg-blue-50">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.sermons.destroy', $sermon) }}" class="flex-1"
                                  onsubmit="return confirm('Delete this sermon permanently?')">
                                @csrf
                                @method('DELETE')
                                <button class="w-full rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $sermons->links() }}</div>
    @endif
</x-admin-layout>
