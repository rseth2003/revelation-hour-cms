<x-admin-layout>
<div class="mb-8 flex flex-wrap items-start justify-between gap-4">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[.2em] text-lime-600">Church Operations</p>
        <h1 class="text-3xl font-bold text-[#072f68]">Attendance Management</h1>
        <p class="mt-2 text-slate-600">Record services, events, members present and visitor totals.</p>
    </div>
    <a href="{{ route('admin.attendance.create') }}" class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Record attendance</a>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
@endif

<section class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
@foreach([
    ['Sessions',$stats['sessions'],'◷','Recorded attendance sessions'],
    ['This Month',$stats['this_month'],'▥','Total attendance this month'],
    ['Members Present',$stats['members_present'],'👥','All recorded member check-ins'],
    ['Visitors',$stats['visitors'],'◎','Unregistered visitors recorded'],
] as [$label,$value,$icon,$description])
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-slate-500">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-[#072f68]">{{ number_format($value) }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $description }}</p>
        </div>
        <span class="grid h-11 w-11 place-items-center rounded-xl bg-slate-100">{{ $icon }}</span>
    </div>
</article>
@endforeach
</section>

<form method="GET" class="mb-6 grid gap-4 rounded-2xl border bg-white p-5 shadow-sm sm:grid-cols-[1fr_1fr_auto]">
    <select name="service_type" class="rounded-xl border-slate-300">
        <option value="">All service types</option>
        @foreach($serviceTypes as $key=>$label)
            <option value="{{ $key }}" @selected(request('service_type') === $key)>{{ $label }}</option>
        @endforeach
    </select>
    <select name="campus_id" class="rounded-xl border-slate-300">
        <option value="">All campuses</option>
        @foreach($campuses as $campus)
            <option value="{{ $campus->id }}" @selected((string) request('campus_id') === (string) $campus->id)>{{ $campus->name }}</option>
        @endforeach
    </select>
    <button class="rounded-xl bg-slate-100 px-5 py-3 font-semibold text-slate-700">Filter</button>
</form>

<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Session</th>
                <th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Date</th>
                <th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Campus</th>
                <th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Members</th>
                <th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Visitors</th>
                <th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
        @forelse($sessions as $session)
            @php $visitors = $session->adult_visitors + $session->youth_visitors + $session->children_visitors; @endphp
            <tr>
                <td class="px-5 py-4">
                    <a href="{{ route('admin.attendance.show', ['attendance' => $session->id]) }}" class="font-bold text-[#072f68]">{{ $session->title }}</a>
                    <p class="text-xs text-slate-500">{{ $serviceTypes[$session->service_type] ?? str($session->service_type)->replace('_',' ')->title() }}</p>
                </td>
                <td class="px-5 py-4 text-sm">{{ $session->held_at->format('d M Y, H:i') }}</td>
                <td class="px-5 py-4 text-sm">{{ $session->campus->name ?? 'Not selected' }}</td>
                <td class="px-5 py-4 font-semibold">{{ $session->registered_members_present }}</td>
                <td class="px-5 py-4 font-semibold">{{ $visitors }}</td>
                <td class="px-5 py-4 text-lg font-bold text-[#072f68]">{{ $session->total_attendance }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">No attendance sessions recorded yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $sessions->links() }}</div>
</x-admin-layout>
