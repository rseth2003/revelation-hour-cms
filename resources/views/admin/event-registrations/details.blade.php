<x-admin-layout title="{{ $registration->full_name }} | Event Registration" heading="Registration Details">
    <div class="mx-auto max-w-4xl">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
            <div>
                <a href="{{ route('admin.event-registrations.show', $event) }}"
                   class="text-sm font-semibold text-blue-700 hover:underline">
                    ← Back to {{ $event->title }} registrations
                </a>
                <h2 class="mt-2 text-2xl font-bold text-[#072f68]">{{ $registration->full_name }}</h2>
                <p class="mt-1 text-sm text-slate-600">{{ $event->title }}</p>
            </div>

            <div class="flex flex-wrap gap-2">
                @if($registration->status === 'confirmed' && ! $registration->checked_in_at)
                    <form method="POST"
                          action="{{ route('admin.event-registrations.check-in', [$event, $registration]) }}"
                          onsubmit="return confirm('Check in {{ addslashes($registration->full_name) }} now?')">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-xl bg-blue-700 px-5 py-3 font-bold text-white hover:bg-blue-800">
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
                        <button class="rounded-xl border border-slate-300 bg-white px-5 py-3 font-bold text-slate-700 hover:bg-slate-50">
                            Undo Check-in
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 font-semibold text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
            <section class="rounded-2xl border bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-[#072f68]">Registrant Information</h3>

                <dl class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Full name</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $registration->full_name }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Phone</dt>
                        <dd class="mt-1 font-semibold text-slate-900">{{ $registration->phone }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Email</dt>
                        <dd class="mt-1 text-slate-800">{{ $registration->email ?: 'Not provided' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Registration type</dt>
                        <dd class="mt-1 capitalize text-slate-800">{{ $registration->registration_type }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Campus</dt>
                        <dd class="mt-1 text-slate-800">{{ $registration->campus?->name ?? 'Not selected' }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wide text-slate-500">Registered</dt>
                        <dd class="mt-1 text-slate-800">{{ $registration->created_at->format('D, j M Y • g:i A') }}</dd>
                    </div>
                </dl>

                <div class="mt-6 border-t pt-5">
                    <h4 class="text-xs font-bold uppercase tracking-wide text-slate-500">Notes</h4>
                    <p class="mt-2 whitespace-pre-line text-slate-700">{{ $registration->notes ?: 'No notes were provided.' }}</p>
                </div>

                @if($registration->member)
                    <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-green-700">Linked RHMI member</p>
                        <p class="mt-1 font-bold text-green-900">{{ $registration->member->full_name }}</p>
                    </div>
                @endif
            </section>

            <aside class="space-y-5">
                <div class="rounded-2xl border bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-[#072f68]">Current Status</h3>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex rounded-full px-3 py-1.5 text-xs font-bold
                            {{ $registration->status === 'confirmed' ? 'bg-green-100 text-green-800 ring-1 ring-green-200' : '' }}
                            {{ $registration->status === 'cancelled' ? 'bg-red-100 text-red-800 ring-1 ring-red-200' : '' }}
                            {{ $registration->status === 'pending' ? 'bg-amber-100 text-amber-800 ring-1 ring-amber-200' : '' }}">
                            {{ \App\Models\EventRegistration::STATUSES[$registration->status] ?? ucfirst($registration->status) }}
                        </span>

                        @if($registration->checked_in_at)
                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-800 ring-1 ring-blue-200">
                                Checked In
                            </span>
                        @endif
                    </div>

                    @if($registration->checked_in_at)
                        <p class="mt-3 text-sm text-slate-600">
                            Checked in {{ $registration->checked_in_at->format('D, j M Y • g:i A') }}
                        </p>
                    @endif
                </div>

                <div class="rounded-2xl border bg-white p-6 shadow-sm">
                    <h3 class="font-bold text-[#072f68]">Change Status</h3>
                    <div class="mt-4 grid gap-2">
                        @foreach(\App\Models\EventRegistration::STATUSES as $value => $label)
                            @if($registration->status !== $value)
                                <form method="POST"
                                      action="{{ route('admin.event-registrations.status', [$event, $registration]) }}"
                                      @if($value === 'cancelled')
                                          onsubmit="return confirm('Cancel this registration?')"
                                      @endif>
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $value }}">

                                    <button class="w-full rounded-xl border px-4 py-2.5 text-sm font-bold
                                        {{ $value === 'confirmed' ? 'border-green-200 bg-green-50 text-green-700 hover:bg-green-100' : '' }}
                                        {{ $value === 'pending' ? 'border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100' : '' }}
                                        {{ $value === 'cancelled' ? 'border-red-200 bg-red-50 text-red-700 hover:bg-red-100' : '' }}">
                                        Mark as {{ $label }}
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-admin-layout>
