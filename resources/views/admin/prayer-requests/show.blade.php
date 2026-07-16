<x-admin-layout title="Prayer Request | RHMI CMS" heading="Prayer Request">
<div class="mx-auto max-w-5xl">
@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

<div class="grid gap-6 lg:grid-cols-[1.15fr_.85fr]">
<section class="rounded-2xl border bg-white p-6 shadow-sm sm:p-8">
<p class="text-xs font-bold uppercase tracking-[.2em] text-lime-600">{{ $prayerRequest->category }}</p>
<h2 class="mt-2 text-2xl font-bold text-[#072f68]">{{ $prayerRequest->is_anonymous ? 'Anonymous Prayer Request' : ($prayerRequest->name ?: 'Prayer Request') }}</h2>
<div class="mt-6 rounded-2xl bg-slate-50 p-5"><p class="whitespace-pre-line leading-8 text-slate-700">{{ $prayerRequest->request_text }}</p></div>

<div class="mt-6 grid gap-4 sm:grid-cols-2">
<div class="rounded-xl border p-4"><strong>Submitted</strong><p>{{ $prayerRequest->created_at->format('j M Y, g:i A') }}</p></div>
<div class="rounded-xl border p-4"><strong>Follow up</strong><p>{{ $prayerRequest->allow_follow_up ? 'Allowed' : 'Not requested' }}</p></div>
@if(!$prayerRequest->is_anonymous && $prayerRequest->email)
<div class="rounded-xl border p-4"><strong>Email</strong><p><a href="mailto:{{ $prayerRequest->email }}">{{ $prayerRequest->email }}</a></p></div>
@endif
@if(!$prayerRequest->is_anonymous && $prayerRequest->phone)
<div class="rounded-xl border p-4"><strong>Phone</strong><p><a href="tel:{{ $prayerRequest->phone }}">{{ $prayerRequest->phone }}</a></p></div>
@endif
</div>
</section>

<aside class="rounded-2xl border bg-white p-6 shadow-sm">
<h3 class="text-xl font-bold text-[#072f68]">Prayer Team Update</h3>
<form method="POST" action="{{ route('admin.prayer-requests.update', $prayerRequest) }}" class="mt-6 space-y-5">
@csrf
@method('PUT')
<div>
<label class="mb-2 block text-sm font-semibold">Status</label>
<select name="status" class="w-full rounded-xl border-slate-300">
@foreach(\App\Models\PrayerRequest::STATUSES as $value => $label)
<option value="{{ $value }}" @selected($prayerRequest->status === $value)>{{ $label }}</option>
@endforeach
</select>
</div>
<div><label class="mb-2 block text-sm font-semibold">Assigned to</label><input name="assigned_to" value="{{ old('assigned_to', $prayerRequest->assigned_to) }}" class="w-full rounded-xl border-slate-300"></div>
<div><label class="mb-2 block text-sm font-semibold">Internal notes</label><textarea name="internal_notes" rows="8" class="w-full rounded-xl border-slate-300">{{ old('internal_notes', $prayerRequest->internal_notes) }}</textarea></div>
<button class="w-full rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Save Update</button>
</form>

<form method="POST" action="{{ route('admin.prayer-requests.destroy', $prayerRequest) }}" class="mt-4" onsubmit="return confirm('Delete this prayer request?')">
@csrf
@method('DELETE')
<button class="w-full rounded-xl border border-red-200 px-5 py-3 font-semibold text-red-700">Delete Request</button>
</form>
</aside>
</div>
</div>
</x-admin-layout>
