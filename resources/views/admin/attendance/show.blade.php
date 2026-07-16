<x-admin-layout title="Attendance Report | RHMI CMS" heading="Attendance Report">
<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
<div>
<p class="text-xs font-bold uppercase tracking-[.2em] text-lime-600">{{ $service->service_date->format('j M Y') }}</p>
<h2 class="mt-2 text-2xl font-bold text-[#072f68]">{{ $service->title }}</h2>
<p class="mt-1 text-sm text-slate-600">{{ $service->campus?->name ?: 'All campuses' }}</p>
</div>

<div class="flex gap-3">
<a href="{{ route('admin.attendance.mark',$service) }}" class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Edit Attendance</a>
<form method="POST" action="{{ route('admin.attendance.destroy',$service) }}" onsubmit="return confirm('Delete this service and all attendance records?')">
@csrf
@method('DELETE')
<button class="rounded-xl border border-red-200 px-5 py-3 font-semibold text-red-700">Delete Service</button>
</form>
</div>
</div>

<div class="mb-6 grid gap-4 sm:grid-cols-3">
<article class="rounded-2xl border bg-white p-5 shadow-sm"><span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">Present</span><p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $counts['present'] }}</p></article>
<article class="rounded-2xl border bg-white p-5 shadow-sm"><span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">Absent</span><p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $counts['absent'] }}</p></article>
<article class="rounded-2xl border bg-white p-5 shadow-sm"><span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">Excused</span><p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $counts['excused'] }}</p></article>
</div>

@if($records->isEmpty())
<div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">No attendance has been recorded.</div>
@else
<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-slate-200">
<thead class="bg-slate-50">
<tr>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Person</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Campus</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Recorded By</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100">
@foreach($records as $record)
<tr>
<td class="px-5 py-4"><p class="font-semibold text-[#072f68]">{{ $record->member->full_name }}</p><p class="text-xs text-slate-500">{{ $record->member->member_number }}</p></td>
<td class="px-5 py-4 text-sm text-slate-600">{{ $record->member->campus?->name ?: 'Not assigned' }}</td>
<td class="px-5 py-4"><span class="rounded-full px-3 py-1 text-xs font-bold {{ $record->attendance_status === 'present' ? 'bg-green-100 text-green-700' : ($record->attendance_status === 'absent' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($record->attendance_status) }}</span></td>
<td class="px-5 py-4 text-sm text-slate-600">{{ $record->recorder?->name ?: 'Unknown' }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<div class="mt-6">{{ $records->links() }}</div>
@endif
</x-admin-layout>
