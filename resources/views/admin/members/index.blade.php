<x-admin-layout title="Members | RHMI CMS" heading="Members">
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-[#072f68]">Member Management</h2>
        <p class="mt-1 text-sm text-slate-600">Manage visitors, members, leaders and communication consent.</p>
    </div>

    <a href="{{ route('admin.members.create') }}" class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">+ Add Person</a>
</div>

@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
@foreach([
    ['Total Records',$counts['total'],'bg-slate-100 text-slate-700'],
    ['Active Members',$counts['active'],'bg-green-100 text-green-700'],
    ['Visitors',$counts['visitors'],'bg-blue-100 text-blue-700'],
    ['Pending Review',$counts['pending'],'bg-amber-100 text-amber-700'],
] as [$label,$count,$classes])
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $classes }}">{{ $label }}</span>
    <p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $count }}</p>
</article>
@endforeach
</div>

<form method="GET" class="mb-6 grid gap-3 rounded-2xl border bg-white p-4 shadow-sm md:grid-cols-4">
    <input name="search" value="{{ request('search') }}" placeholder="Search name, phone or number" class="rounded-xl border-slate-300">

    <select name="membership_type" class="rounded-xl border-slate-300">
        <option value="">All types</option>
        @foreach(\App\Models\Member::MEMBERSHIP_TYPES as $value => $label)
            <option value="{{ $value }}" @selected(request('membership_type') === $value)>{{ $label }}</option>
        @endforeach
    </select>

    <select name="membership_status" class="rounded-xl border-slate-300">
        <option value="">All statuses</option>
        @foreach(\App\Models\Member::STATUSES as $value => $label)
            <option value="{{ $value }}" @selected(request('membership_status') === $value)>{{ $label }}</option>
        @endforeach
    </select>

    <button class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Filter</button>
</form>

@if($members->isEmpty())
<div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">No member records found.</div>
@else
<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
<div class="overflow-x-auto">
<table class="min-w-full divide-y divide-slate-200">
<thead class="bg-slate-50">
<tr>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Person</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Contact</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Campus</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Type</th>
<th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
<th class="px-5 py-4"></th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100">
@foreach($members as $member)
<tr>
<td class="px-5 py-4">
<div class="flex items-center gap-3">
@if($member->photo_url)
<img src="{{ $member->photo_url }}" class="h-11 w-11 rounded-full object-cover">
@else
<div class="grid h-11 w-11 place-items-center rounded-full bg-blue-100 font-bold text-blue-700">{{ strtoupper(substr($member->first_name,0,1).substr($member->last_name,0,1)) }}</div>
@endif
<div><p class="font-semibold text-[#072f68]">{{ $member->full_name }}</p><p class="text-xs text-slate-500">{{ $member->member_number }}</p></div>
</div>
</td>
<td class="px-5 py-4 text-sm text-slate-600"><p>{{ $member->phone ?: 'No phone' }}</p><p>{{ $member->email ?: 'No email' }}</p></td>
<td class="px-5 py-4 text-sm text-slate-600">{{ $member->campus?->name ?: 'Not assigned' }}</td>
<td class="px-5 py-4 text-sm text-slate-600">{{ \App\Models\Member::MEMBERSHIP_TYPES[$member->membership_type] ?? ucfirst($member->membership_type) }}</td>
<td class="px-5 py-4"><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ \App\Models\Member::STATUSES[$member->membership_status] ?? ucfirst($member->membership_status) }}</span></td>
<td class="px-5 py-4 text-right"><a href="{{ route('admin.members.show',$member) }}" class="rounded-lg bg-[#072f68] px-4 py-2 text-sm font-semibold text-white">Open</a></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<div class="mt-6">{{ $members->links() }}</div>
@endif
</x-admin-layout>
