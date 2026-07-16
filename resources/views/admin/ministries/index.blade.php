<x-admin-layout title="Ministries | RHMI CMS" heading="Ministries">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#072f68]">Ministries</h2>
            <p class="mt-1 text-sm text-slate-600">Create and manage ministry pages, leaders, schedules and images.</p>
        </div>

        <a href="{{ route('admin.ministries.create') }}"
           class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68] shadow hover:bg-lime-400">
            + Add Ministry
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($ministries->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <p class="text-lg font-semibold text-[#072f68]">No ministries yet</p>
            <p class="mt-2 text-sm text-slate-500">Add your first ministry and publish it to the website.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($ministries as $ministry)
                <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                    @if($ministry->cover_image_url)
                        <img src="{{ $ministry->cover_image_url }}" alt="{{ $ministry->name }}" class="h-52 w-full object-cover">
                    @else
                        <div class="grid h-52 place-items-center bg-gradient-to-br from-[#072f68] to-[#0d5fa8] text-xl font-bold text-white">
                            {{ $ministry->name }}
                        </div>
                    @endif

                    <div class="p-5">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h3 class="font-bold text-[#072f68]">{{ $ministry->name }}</h3>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $ministry->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $ministry->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <p class="text-sm leading-6 text-slate-600">{{ $ministry->short_description }}</p>

                        @if($ministry->leader_name)
                            <p class="mt-3 text-sm text-slate-500"><strong>Leader:</strong> {{ $ministry->leader_name }}</p>
                        @endif

                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('admin.ministries.edit', $ministry) }}"
                               class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-center text-sm font-semibold text-blue-700 hover:bg-blue-50">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('admin.ministries.destroy', $ministry) }}" class="flex-1"
                                  onsubmit="return confirm('Delete this ministry permanently?')">
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

        <div class="mt-6">{{ $ministries->links() }}</div>
    @endif
</x-admin-layout>
