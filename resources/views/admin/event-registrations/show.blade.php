<x-admin-layout title="{{ $event->title }} Registrations | RHMI CMS" heading="Event Registrations">
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <a href="{{ route('admin.event-registrations.index') }}" class="text-sm font-semibold text-blue-700 hover:underline">
                ← All event registrations
            </a>
            <h2 class="mt-2 text-2xl font-bold text-[#072f68]">{{ $event->title }}</h2>
            @if($event->event_date)
                <p class="mt-1 text-sm text-slate-600">{{ $event->event_date->format('D, j M Y • g:i A') }}</p>
            @endif
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.event-registrations.export', array_merge(['event' => $event], request()->query())) }}"
               class="rounded-xl border border-green-200 bg-green-50 px-5 py-3 font-bold text-green-700 hover:bg-green-100">
                Export CSV
            </a>

            <a href="{{ route('event-registration.create', $event) }}" target="_blank"
               class="rounded-xl border border-blue-200 bg-white px-5 py-3 font-semibold text-blue-700 hover:bg-blue-50">
                Open Public Form
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('check_in'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 font-semibold text-red-800">
            {{ $errors->first('check_in') }}
        </div>
    @endif

    <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach([
            ['Total', $summary['total'], 'border-slate-200 bg-white text-slate-700'],
            ['Pending', $summary['pending'], 'border-amber-200 bg-amber-50 text-amber-800'],
            ['Confirmed', $summary['confirmed'], 'border-green-200 bg-green-50 text-green-800'],
            ['Checked In', $summary['checked_in'], 'border-blue-200 bg-blue-50 text-blue-800'],
            ['Cancelled', $summary['cancelled'], 'border-red-200 bg-red-50 text-red-800'],
        ] as [$label, $value, $classes])
            <div class="rounded-2xl border p-5 shadow-sm {{ $classes }}">
                <p class="text-sm font-bold">{{ $label }}</p>
                <p class="mt-2 text-3xl font-black">{{ $value }}</p>
            </div>
        @endforeach
    </div>

    <form method="GET" class="mb-6 grid gap-3 rounded-2xl border bg-white p-4 shadow-sm lg:grid-cols-[1fr_170px_170px_190px_auto]">
        <input type="search" name="search" value="{{ request('search') }}"
               placeholder="Name, phone or email"
               class="rounded-xl border-slate-300 focus:border-blue-600 focus:ring-blue-600">

        <select name="status" class="rounded-xl border-slate-300">
            <option value="">All statuses</option>
            @foreach(\App\Models\EventRegistration::STATUSES as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="type" class="rounded-xl border-slate-300">
            <option value="">All types</option>
            @foreach(\App\Models\EventRegistration::TYPES as $value => $label)
                <option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        <select name="check_in" class="rounded-xl border-slate-300">
            <option value="">All check-in states</option>
            <option value="checked_in" @selected(request('check_in') === 'checked_in')>Checked In</option>
            <option value="not_checked_in" @selected(request('check_in') === 'not_checked_in')>Not Checked In</option>
        </select>

        <button class="rounded-xl bg-[#072f68] px-5 py-2.5 font-semibold text-white">Filter</button>
    </form>

    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
        @if($registrations->isEmpty())
            <div class="p-10 text-center text-slate-500">No registrations match the selected filters.</div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Registrant</th>
                            <th class="px-5 py-3">Contact</th>
                            <th class="px-5 py-3">Type</th>
                            <th class="px-5 py-3">Campus</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Check-in</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($registrations as $registration)
                            <tr class="align-top">
                                <td class="px-5 py-4">
                                    <p class="font-bold text-[#072f68]">{{ $registration->full_name }}</p>

                                    @if($registration->member)
                                        <p class="mt-1 text-xs text-green-700">
                                            Linked member: {{ $registration->member->full_name }}
                                        </p>
                                    @endif

                                    @if($registration->notes)
                                        <p class="mt-2 max-w-sm text-xs text-slate-500">
                                            {{ \Illuminate\Support\Str::limit($registration->notes, 70) }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <p>{{ $registration->phone }}</p>

                                    @if($registration->email)
                                        <p class="mt-1 text-xs text-slate-500">{{ $registration->email }}</p>
                                    @endif

                                    <p class="mt-2 text-xs text-slate-400">
                                        {{ $registration->created_at->format('j M Y, g:i A') }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 capitalize">{{ $registration->registration_type }}</td>
                                <td class="px-5 py-4">{{ $registration->campus?->name ?? '—' }}</td>

                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-bold
                                        {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800 ring-1 ring-green-200' : '' }}
                                        {{ $registration->status === 'cancelled' ? 'bg-red-100 text-red-800 ring-1 ring-red-200' : '' }}
                                        {{ $registration->status === 'pending' ? 'bg-amber-100 text-amber-800 ring-1 ring-amber-200' : '' }}">
                                        {{ \App\Models\EventRegistration::STATUSES[$registration->status] ?? ucfirst($registration->status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    @if($registration->checked_in_at)
                                        <span class="inline-flex rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-800 ring-1 ring-blue-200">
                                            Checked In
                                        </span>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $registration->checked_in_at->format('j M, g:i A') }}
                                        </p>
                                    @else
                                        <span class="text-slate-400">Not checked in</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex min-w-max flex-wrap justify-end gap-2">
                                        <a href="{{ route('admin.event-registrations.details', [$event, $registration]) }}"
                                           class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">
                                            View
                                        </a>

                                        @if($registration->status !== 'confirmed')
                                            <form method="POST" action="{{ route('admin.event-registrations.status', [$event, $registration]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">

                                                <button class="rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs font-bold text-green-700 hover:bg-green-100">
                                                    Confirm
                                                </button>
                                            </form>
                                        @endif

                                        @if($registration->status === 'confirmed' && ! $registration->checked_in_at)
                                            <form method="POST"
                                                  action="{{ route('admin.event-registrations.check-in', [$event, $registration]) }}"
                                                  onsubmit="return confirm('Check in {{ addslashes($registration->full_name) }} now?')">
                                                @csrf
                                                @method('PATCH')

                                                <button class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-100">
                                                    Check In
                                                </button>
                                            </form>
                                        @endif

                                        @if($registration->checked_in_at)
                                            <form method="POST"
                                                  action="{{ route('admin.event-registrations.undo-check-in', [$event, $registration]) }}"
                                                  onsubmit="return confirm('Undo check-in for {{ addslashes($registration->full_name) }}?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">
                                                    Undo Check-in
                                                </button>
                                            </form>
                                        @endif

                                        @if($registration->status !== 'cancelled')
                                            <form method="POST" action="{{ route('admin.event-registrations.status', [$event, $registration]) }}"
                                                  onsubmit="return confirm('Cancel this registration?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">

                                                <button class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif

                                        @if($registration->status !== 'pending')
                                            <form method="POST" action="{{ route('admin.event-registrations.status', [$event, $registration]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">

                                                <button class="rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-bold text-amber-700 hover:bg-amber-100">
                                                    Pending
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="mt-6">{{ $registrations->links() }}</div>
</x-admin-layout>
