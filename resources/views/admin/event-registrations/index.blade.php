<x-admin-layout title="Event Registrations | RHMI CMS" heading="Event Registrations">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-[#072f68]">Event Registrations</h2>
            <p class="mt-1 text-sm text-slate-600">Select an event to manage registrations and check-ins.</p>
        </div>
        <a href="{{ route('admin.events.index') }}"
           class="rounded-xl border border-slate-300 bg-white px-5 py-3 font-semibold text-slate-700 hover:bg-slate-50">
            Manage Events
        </a>
    </div>

    <form method="GET" class="mb-6 flex max-w-xl gap-2">
        <input type="search" name="search" value="{{ request('search') }}"
               placeholder="Search events..."
               class="min-w-0 flex-1 rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">
        <button class="rounded-xl bg-[#072f68] px-5 py-2.5 font-semibold text-white">Search</button>
    </form>

    @if($events->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
            <p class="text-lg font-semibold text-[#072f68]">No events found</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach($events as $event)
                <article class="rounded-2xl border bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-bold text-[#072f68]">{{ $event->title }}</h3>
                            @if($event->event_date)
                                <p class="mt-1 text-sm text-slate-600">{{ $event->event_date->format('D, j M Y • g:i A') }}</p>
                            @endif
                        </div>
                        <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-bold text-blue-700">
                            {{ $event->registrations_count }}
                        </span>
                    </div>

                    <p class="mt-4 text-sm text-slate-500">
                        {{ $event->registrations_count }}
                        {{ \Illuminate\Support\Str::plural('registration', $event->registrations_count) }}
                    </p>

                    <a href="{{ route('admin.event-registrations.show', $event) }}"
                       class="mt-5 block rounded-xl bg-[#072f68] px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-blue-900">
                        Manage Registrations
                    </a>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $events->links() }}</div>
    @endif
</x-admin-layout>
