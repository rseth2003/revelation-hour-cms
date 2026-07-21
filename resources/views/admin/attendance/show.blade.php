<x-admin-layout>
<div class="mb-8 flex flex-wrap items-start justify-between gap-4">
    <div>
        <a href="{{ route('admin.attendance.index') }}" class="text-sm font-semibold text-slate-500">← Attendance Management</a>
        <h1 class="mt-3 text-3xl font-bold text-[#072f68]">{{ $attendance->title }}</h1>
        <p class="mt-2 text-slate-600">
            {{ App\Models\AttendanceSession::SERVICE_TYPES[$attendance->service_type] ?? str($attendance->service_type)->replace('_',' ')->title() }}
            · {{ $attendance->held_at?->format('d M Y, H:i') ?? 'Date not recorded' }}
        </p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.attendance.edit', ['attendance' => $attendance->id]) }}" class="rounded-xl border px-5 py-3 font-semibold text-slate-700">Edit</a>
        <form method="POST" action="{{ route('admin.attendance.destroy', ['attendance' => $attendance->id]) }}" onsubmit="return confirm('Delete this attendance session?')">
            @csrf @method('DELETE')
            <button class="rounded-xl bg-red-600 px-5 py-3 font-semibold text-white">Delete</button>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
@endif

<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
@foreach([
    ['Members',$attendance->registered_members_present],
    ['Adult Visitors',$attendance->adult_visitors],
    ['Youth Visitors',$attendance->youth_visitors],
    ['Children',$attendance->children_visitors],
    ['Total',$attendance->total_attendance],
] as [$label,$value])
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <p class="text-sm font-semibold text-slate-500">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold text-[#072f68]">{{ $value }}</p>
</article>
@endforeach
</section>

<section class="mt-8 grid gap-6 lg:grid-cols-[.7fr_1.3fr]">
    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#072f68]">Session details</h2>
        <dl class="mt-5 space-y-4 text-sm">
            <div><dt class="font-semibold text-slate-500">Campus</dt><dd class="mt-1 text-slate-800">{{ $attendance->campus->name ?? 'Not selected' }}</dd></div>
            <div><dt class="font-semibold text-slate-500">Related event</dt><dd class="mt-1 text-slate-800">{{ $attendance->event->title ?? 'Not linked' }}</dd></div>
            <div><dt class="font-semibold text-slate-500">Date and time</dt><dd class="mt-1 text-slate-800">{{ $attendance->held_at?->format('l, d F Y · H:i') ?? 'Date not recorded' }}</dd></div>
            @if($attendance->notes)
                <div><dt class="font-semibold text-slate-500">Notes</dt><dd class="mt-1 whitespace-pre-line leading-6 text-slate-700">{{ $attendance->notes }}</dd></div>
            @endif
        </dl>
    </article>

    <article class="rounded-2xl border bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-[#072f68]">Members present</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $attendance->records->count() }} registered check-ins</p>
            </div>
        </div>
        <div class="mt-5 max-h-[560px] divide-y overflow-y-auto">
            @forelse($attendance->records as $record)
                <div class="flex items-center justify-between gap-4 py-3">
                    <div>
                        <p class="font-semibold text-slate-800">{{ $record->member->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $record->member->campus->name ?? 'No campus' }} · {{ $record->member->ministry->name ?? 'No ministry' }}</p>
                    </div>
                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">Present</span>
                </div>
            @empty
                <p class="py-10 text-center text-sm text-slate-500">No registered members were marked present.</p>
            @endforelse
        </div>
    </article>
</section>
</x-admin-layout>
