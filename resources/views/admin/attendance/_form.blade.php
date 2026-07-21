@php
    $editing = isset($attendance);
    $selected = collect(old('member_ids', $selectedMemberIds ?? []))->map(fn($id) => (int) $id)->all();
@endphp

<div class="grid gap-6 xl:grid-cols-[.8fr_1.2fr]">
    <section class="space-y-5 rounded-2xl border bg-white p-6 shadow-sm">
        <div>
            <label class="mb-2 block text-sm font-semibold">Session title</label>
            <input name="title" value="{{ old('title', $attendance->title ?? '') }}" class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Service type</label>
            <select name="service_type" class="w-full rounded-xl border-slate-300" required>
                @foreach($serviceTypes as $key => $label)
                    <option value="{{ $key }}" @selected(old('service_type', $attendance->service_type ?? 'sunday_service') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Date and time</label>
            <input type="datetime-local" name="held_at"
                   value="{{ old('held_at', isset($attendance) ? $attendance->held_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-xl border-slate-300" required>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Campus</label>
            <select name="campus_id" class="w-full rounded-xl border-slate-300">
                <option value="">No campus selected</option>
                @foreach($campuses as $campus)
                    <option value="{{ $campus->id }}" @selected((string) old('campus_id', $attendance->campus_id ?? '') === (string) $campus->id)>{{ $campus->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Related event</label>
            <select name="event_id" class="w-full rounded-xl border-slate-300">
                <option value="">Not linked to an event</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" @selected((string) old('event_id', $attendance->event_id ?? '') === (string) $event->id)>
                        {{ $event->title }} — {{ $event->event_date?->format('d M Y') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <p class="mb-3 text-sm font-semibold">Unregistered visitors</p>
            <div class="grid gap-4 sm:grid-cols-3">
                <div>
                    <label class="mb-2 block text-xs font-semibold text-slate-500">Adults</label>
                    <input type="number" min="0" name="adult_visitors" value="{{ old('adult_visitors', $attendance->adult_visitors ?? 0) }}" class="w-full rounded-xl border-slate-300" required>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-semibold text-slate-500">Youth</label>
                    <input type="number" min="0" name="youth_visitors" value="{{ old('youth_visitors', $attendance->youth_visitors ?? 0) }}" class="w-full rounded-xl border-slate-300" required>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-semibold text-slate-500">Children</label>
                    <input type="number" min="0" name="children_visitors" value="{{ old('children_visitors', $attendance->children_visitors ?? 0) }}" class="w-full rounded-xl border-slate-300" required>
                </div>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Notes</label>
            <textarea name="notes" rows="4" class="w-full rounded-xl border-slate-300">{{ old('notes', $attendance->notes ?? '') }}</textarea>
        </div>
    </section>

    <section class="rounded-2xl border bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-[#072f68]">Members present</h2>
                <p class="mt-1 text-sm text-slate-500">Tick registered members who attended.</p>
            </div>
            <div class="flex gap-2">
                <button type="button" data-select-all class="rounded-lg border px-3 py-2 text-xs font-semibold">Select all</button>
                <button type="button" data-clear-all class="rounded-lg border px-3 py-2 text-xs font-semibold">Clear</button>
            </div>
        </div>

        <div class="mt-5">
            <input type="search" data-member-search placeholder="Search member, campus or ministry..."
                   class="w-full rounded-xl border-slate-300">
        </div>

        <div class="mt-5 max-h-[620px] space-y-2 overflow-y-auto pr-2" data-member-list>
            @forelse($members as $member)
                <label class="member-attendance-row flex cursor-pointer items-center gap-3 rounded-xl border px-4 py-3 hover:bg-slate-50"
                       data-search="{{ strtolower($member->full_name.' '.($member->campus->name ?? '').' '.($member->ministry->name ?? '')) }}">
                    <input type="checkbox" name="member_ids[]" value="{{ $member->id }}"
                           @checked(in_array($member->id, $selected, true))
                           class="rounded border-slate-300 text-[#072f68] focus:ring-[#072f68]">
                    <span class="min-w-0 flex-1">
                        <span class="block truncate font-semibold text-slate-800">{{ $member->full_name }}</span>
                        <span class="block truncate text-xs text-slate-500">
                            {{ $member->campus->name ?? 'No campus' }} · {{ $member->ministry->name ?? 'No ministry' }}
                        </span>
                    </span>
                </label>
            @empty
                <p class="rounded-xl bg-slate-50 p-6 text-center text-sm text-slate-500">No active members found.</p>
            @endforelse
        </div>
    </section>
</div>

@if($errors->any())
    <div class="mt-6 rounded-xl bg-red-50 p-4 text-red-700">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="mt-8 flex gap-3">
    <button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">
        {{ $editing ? 'Update attendance' : 'Save attendance' }}
    </button>
    <a href="{{ route('admin.attendance.index') }}" class="rounded-xl border px-6 py-3 font-semibold text-slate-600">Cancel</a>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const rows = [...document.querySelectorAll('.member-attendance-row')];
    const search = document.querySelector('[data-member-search]');
    search?.addEventListener('input', () => {
        const term = search.value.toLowerCase().trim();
        rows.forEach(row => row.hidden = !row.dataset.search.includes(term));
    });
    document.querySelector('[data-select-all]')?.addEventListener('click', () => {
        rows.filter(row => !row.hidden).forEach(row => row.querySelector('input').checked = true);
    });
    document.querySelector('[data-clear-all]')?.addEventListener('click', () => {
        rows.forEach(row => row.querySelector('input').checked = false);
    });
});
</script>
