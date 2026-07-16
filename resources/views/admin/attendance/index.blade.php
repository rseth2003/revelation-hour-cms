<x-admin-layout title="Attendance | RHMI CMS" heading="Attendance">
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-[#072f68]">Attendance Management</h2>
        <p class="mt-1 text-sm text-slate-600">Create services and record member or visitor attendance.</p>
    </div>

    <a href="{{ route('admin.attendance.create') }}" class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">
        + New Service
    </a>
</div>

@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

<div class="mb-6 grid gap-4 sm:grid-cols-3">
    <article class="rounded-2xl border bg-white p-5 shadow-sm">
        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">Services Created</span>
        <p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $stats['services'] }}</p>
    </article>

    <article class="rounded-2xl border bg-white p-5 shadow-sm">
        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">Present Today</span>
        <p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $stats['today'] }}</p>
    </article>

    <article class="rounded-2xl border bg-white p-5 shadow-sm">
        <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-700">Present This Month</span>
        <p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $stats['this_month'] }}</p>
    </article>
</div>

@if($services->isEmpty())
<div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">
    No church services have been created yet.
</div>
@else
<div class="grid gap-4">
@foreach($services as $service)
<article class="rounded-2xl border bg-white p-5 shadow-sm">
<div class="flex flex-wrap items-start justify-between gap-5">
<div>
    <p class="text-xs font-bold uppercase tracking-wide text-lime-600">
        {{ \App\Models\ChurchService::TYPES[$service->service_type] ?? ucfirst(str_replace('_',' ',$service->service_type)) }}
    </p>
    <h3 class="mt-1 text-xl font-bold text-[#072f68]">{{ $service->title }}</h3>
    <p class="mt-2 text-sm text-slate-600">
        {{ $service->service_date->format('j M Y') }}
        @if($service->start_time) at {{ \Illuminate\Support\Carbon::parse($service->start_time)->format('g:i A') }} @endif
    </p>
    <p class="mt-1 text-sm text-slate-500">{{ $service->campus?->name ?: 'All campuses' }}</p>
</div>

<div class="flex flex-wrap items-center gap-3">
    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">{{ $service->present_count }} Present</span>
    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">{{ $service->absent_count }} Absent</span>
    <a href="{{ route('admin.attendance.mark',$service) }}" class="rounded-lg bg-[#072f68] px-4 py-2 text-sm font-semibold text-white">Mark Attendance</a>
    <a href="{{ route('admin.attendance.show',$service) }}" class="rounded-lg border border-blue-200 px-4 py-2 text-sm font-semibold text-blue-700">View Report</a>
</div>
</div>
</article>
@endforeach
</div>

<div class="mt-6">{{ $services->links() }}</div>
@endif
</x-admin-layout>
