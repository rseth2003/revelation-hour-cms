<x-admin-layout title="Mark Attendance | RHMI CMS" heading="Mark Attendance">
<div class="mb-6">
<p class="text-xs font-bold uppercase tracking-[.2em] text-lime-600">{{ $service->service_date->format('j M Y') }}</p>
<h2 class="mt-2 text-2xl font-bold text-[#072f68]">{{ $service->title }}</h2>
<p class="mt-1 text-sm text-slate-600">{{ $service->campus?->name ?: 'All campuses' }}</p>
</div>

@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

<form method="GET" class="mb-5 flex gap-3 rounded-2xl border bg-white p-4 shadow-sm">
<input name="search" value="{{ request('search') }}" placeholder="Search member, number or phone" class="min-w-0 flex-1 rounded-xl border-slate-300">
<button class="rounded-xl bg-slate-800 px-5 py-3 font-semibold text-white">Search</button>
</form>

<form method="POST" action="{{ route('admin.attendance.save',$service) }}">
@csrf
@method('PUT')

<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-slate-200">
<thead class="bg-slate-50">
<tr>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Person</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Campus</th>
<th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wide text-green-600">Present</th>
<th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wide text-red-600">Absent</th>
<th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wide text-amber-600">Excused</th>
</tr>
</thead>

<tbody class="divide-y divide-slate-100">
@foreach($members as $member)
@php($current = $existing->get($member->id)?->attendance_status)
<tr>
<td class="px-5 py-4">
<p class="font-semibold text-[#072f68]">{{ $member->full_name }}</p>
<p class="text-xs text-slate-500">{{ $member->member_number }} · {{ $member->phone ?: 'No phone' }}</p>
</td>
<td class="px-5 py-4 text-sm text-slate-600">{{ $member->campus?->name ?: 'Not assigned' }}</td>
<td class="px-5 py-4 text-center"><input type="radio" name="attendance[{{ $member->id }}]" value="present" @checked($current === 'present') class="h-5 w-5 text-green-600"></td>
<td class="px-5 py-4 text-center"><input type="radio" name="attendance[{{ $member->id }}]" value="absent" @checked($current === 'absent') class="h-5 w-5 text-red-600"></td>
<td class="px-5 py-4 text-center"><input type="radio" name="attendance[{{ $member->id }}]" value="excused" @checked($current === 'excused') class="h-5 w-5 text-amber-600"></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>

<div class="mt-6 flex flex-wrap items-center justify-between gap-4">
{{ $members->links() }}

<div class="flex gap-3">
<a href="{{ route('admin.attendance.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 font-semibold text-slate-700">Back</a>
<button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">Save Attendance</button>
</div>
</div>
</form>
</x-admin-layout>
