<x-admin-layout title="Live Events | RHMI CMS" heading="Live Events">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#072f68]">Live Events</h2>
            <p class="mt-1 text-sm text-slate-600">Upload and manage event posters for the public website.</p>
        </div>
        <a href="{{ route('admin.events.create') }}"
           class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68] shadow hover:bg-lime-400">
            + New Event
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($events->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <p class="text-lg font-semibold text-[#072f68]">No events yet</p>
            <p class="mt-2 text-sm text-slate-500">Create your first event and upload its poster.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($events as $event)
                <article class="overflow-hidden rounded-2xl border bg-white shadow-sm">
                    @if($event->poster_url)
                        <img src="{{ $event->poster_url }}" alt="{{ $event->title }}" class="h-52 w-full object-cover">
                    @else
                        <div class="grid h-52 place-items-center bg-slate-100 text-slate-400">No poster</div>
                    @endif

                    <div class="p-5">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <h3 class="font-bold text-[#072f68]">{{ $event->title }}</h3>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $event->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $event->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        @if($event->event_date)
                            <p class="text-sm text-slate-600">{{ $event->event_date->format('D, j M Y • g:i A') }}</p>
                        @endif

                        @if($event->location)
                            <p class="mt-1 text-sm text-slate-500">{{ $event->location }}</p>
                        @endif

                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('admin.events.edit', $event) }}"
                               class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-center text-sm font-semibold text-blue-700 hover:bg-blue-50">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="flex-1"
                                  onsubmit="return confirm('Delete this event permanently?')">
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

        <div class="mt-6">{{ $events->links() }}</div>
    @endif
</x-admin-layout>
