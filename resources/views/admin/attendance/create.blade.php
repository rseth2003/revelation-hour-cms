<x-admin-layout title="New Service | RHMI CMS" heading="New Service">
<div class="mx-auto max-w-4xl rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<h2 class="text-2xl font-bold text-[#072f68]">Create a service attendance register</h2>
<p class="mt-1 text-sm text-slate-600">Create the service first, then mark members present, absent or excused.</p>

<form method="POST" action="{{ route('admin.attendance.store') }}" class="mt-8 space-y-5">
@csrf

<div>
<label class="mb-2 block text-sm font-semibold">Service title</label>
<input name="title" value="{{ old('title') }}" placeholder="Example: Sunday Service" class="w-full rounded-xl border-slate-300" required>
</div>

<div class="grid gap-4 sm:grid-cols-2">
<div>
<label class="mb-2 block text-sm font-semibold">Service type</label>
<select name="service_type" class="w-full rounded-xl border-slate-300" required>
@foreach(\App\Models\ChurchService::TYPES as $value => $label)
<option value="{{ $value }}" @selected(old('service_type') === $value)>{{ $label }}</option>
@endforeach
</select>
</div>

<div>
<label class="mb-2 block text-sm font-semibold">Campus</label>
<select name="campus_id" class="w-full rounded-xl border-slate-300">
<option value="">All campuses</option>
@foreach($campuses as $campus)
<option value="{{ $campus->id }}" @selected((string) old('campus_id') === (string) $campus->id)>{{ $campus->name }}</option>
@endforeach
</select>
</div>
</div>

<div class="grid gap-4 sm:grid-cols-3">
<div>
<label class="mb-2 block text-sm font-semibold">Date</label>
<input type="date" name="service_date" value="{{ old('service_date',now()->format('Y-m-d')) }}" class="w-full rounded-xl border-slate-300" required>
</div>

<div>
<label class="mb-2 block text-sm font-semibold">Start time</label>
<input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full rounded-xl border-slate-300">
</div>

<div>
<label class="mb-2 block text-sm font-semibold">End time</label>
<input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full rounded-xl border-slate-300">
</div>
</div>

<div>
<label class="mb-2 block text-sm font-semibold">Status</label>
<select name="status" class="w-full rounded-xl border-slate-300">
@foreach(\App\Models\ChurchService::STATUSES as $value => $label)
<option value="{{ $value }}" @selected(old('status','open') === $value)>{{ $label }}</option>
@endforeach
</select>
</div>

<div>
<label class="mb-2 block text-sm font-semibold">Notes</label>
<textarea name="notes" rows="5" class="w-full rounded-xl border-slate-300">{{ old('notes') }}</textarea>
</div>

@if($errors->any())
<div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
<ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<div class="flex gap-3">
<button class="rounded-xl bg-[#072f68] px-6 py-3 font-semibold text-white">Create and Mark Attendance</button>
<a href="{{ route('admin.attendance.index') }}" class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-700">Cancel</a>
</div>
</form>
</div>
</x-admin-layout>
