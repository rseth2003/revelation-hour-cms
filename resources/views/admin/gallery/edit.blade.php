<x-admin-layout title="Manage Gallery Album | RHMI CMS" heading="Manage Gallery Album">
    <div class="mx-auto max-w-6xl">
        @if(session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
        @endif

        <div class="rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-2xl font-bold text-[#072f68]">Edit {{ $album->title }}</h2>
            <p class="mt-1 text-sm text-slate-600">Update album information or add more photos.</p>

            <form method="POST" action="{{ route('admin.gallery.update', $album) }}" enctype="multipart/form-data" class="mt-8">
                @method('PUT')
                @include('admin.gallery._form', ['buttonText' => 'Save Album'])
            </form>
        </div>

        <section class="mt-8 rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-5">
                <h2 class="text-2xl font-bold text-[#072f68]">Album Photos</h2>
                <p class="mt-1 text-sm text-slate-600">{{ $album->images->count() }} photos uploaded.</p>
            </div>

            @if($album->images->isEmpty())
                <div class="rounded-xl border border-dashed border-slate-300 p-10 text-center text-slate-500">
                    No photos have been uploaded to this album yet.
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach($album->images as $image)
                        <article class="overflow-hidden rounded-xl border bg-slate-50">
                            <img src="{{ $image->image_url }}" alt="{{ $album->title }}" class="h-48 w-full object-cover">

                            <form method="POST"
                                  action="{{ route('admin.gallery.images.destroy', [$album, $image]) }}"
                                  onsubmit="return confirm('Delete this photo?')"
                                  class="p-3">
                                @csrf
                                @method('DELETE')
                                <button class="w-full rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700">
                                    Delete Photo
                                </button>
                            </form>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-admin-layout>
