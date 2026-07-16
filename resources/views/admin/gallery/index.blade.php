<x-admin-layout title="Gallery | RHMI CMS" heading="Gallery">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#072f68]">Gallery Albums</h2>
            <p class="mt-1 text-sm text-slate-600">Create albums, upload photos and publish church memories.</p>
        </div>

        <a href="{{ route('admin.gallery.create') }}"
           class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">
            + New Album
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
    @endif

    @if($albums->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            No gallery albums yet.
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($albums as $album)
                <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                    @if($album->cover_image_url)
                        <img src="{{ $album->cover_image_url }}" alt="{{ $album->title }}" class="h-52 w-full object-cover">
                    @else
                        <div class="grid h-52 place-items-center bg-gradient-to-br from-[#072f68] to-[#0d5fa8] p-6 text-center text-xl font-bold text-white">
                            {{ $album->title }}
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h3 class="font-bold text-[#072f68]">{{ $album->title }}</h3>
                            <div class="flex flex-col gap-1 text-right">
                                @if($album->is_featured)
                                    <span class="rounded-full bg-lime-100 px-2.5 py-1 text-xs font-semibold text-lime-700">Featured</span>
                                @endif
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $album->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $album->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-sm text-slate-500">{{ $album->images_count }} photos</p>

                        @if($album->album_date)
                            <p class="mt-1 text-sm text-slate-500">{{ $album->album_date->format('j M Y') }}</p>
                        @endif

                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('admin.gallery.edit', $album) }}"
                               class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-center text-sm font-semibold text-blue-700">
                                Manage
                            </a>

                            <form method="POST" action="{{ route('admin.gallery.destroy', $album) }}" class="flex-1"
                                  onsubmit="return confirm('Delete this album and every photo inside it?')">
                                @csrf
                                @method('DELETE')
                                <button class="w-full rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $albums->links() }}</div>
    @endif
</x-admin-layout>
