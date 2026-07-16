<x-admin-layout title="Prayer Requests | RHMI CMS" heading="Prayer Requests">
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#072f68]">Prayer Requests</h2>
    <p class="mt-1 text-sm text-slate-600">Review and manage requests submitted from the website.</p>
</div>

@if(session('success'))
<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
@endif

<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
@foreach([
    ['All',$counts['all'],'bg-slate-100 text-slate-700'],
    ['New',$counts['new'],'bg-blue-100 text-blue-700'],
    ['In Progress',$counts['in_progress'],'bg-amber-100 text-amber-700'],
    ['Prayed For',$counts['prayed_for'],'bg-green-100 text-green-700'],
    ['Closed',$counts['closed'],'bg-purple-100 text-purple-700'],
] as [$label,$count,$classes])
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $classes }}">{{ $label }}</span>
    <p class="mt-4 text-3xl font-bold text-[#072f68]">{{ $count }}</p>
</article>
@endforeach
</div>

<form method="GET" class="mb-6 grid gap-3 rounded-2xl border bg-white p-4 shadow-sm md:grid-cols-4">
<input name="search" value="{{ request('search') }}" placeholder="Search requests" class="rounded-xl border-slate-300">
<select name="status" class="rounded-xl border-slate-300">
<option value="">All statuses</option>
@foreach(\App\Models\PrayerRequest::STATUSES as $value => $label)
<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
@endforeach
</select>
<select name="category" class="rounded-xl border-slate-300">
<option value="">All categories</option>
@foreach(\App\Models\PrayerRequest::CATEGORIES as $category)
<option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
@endforeach
</select>
<button class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Filter</button>
</form>

@if($requests->isEmpty())
<div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500">No prayer requests found.</div>
@else
<div class="grid gap-4">
@foreach($requests as $item)
<article class="rounded-2xl border bg-white p-5 shadow-sm">
<div class="flex flex-wrap items-start justify-between gap-4">
<div>
<p class="text-xs font-bold uppercase tracking-wide text-lime-600">{{ $item->category }}</p>
<h3 class="mt-1 font-bold text-[#072f68]">{{ $item->is_anonymous ? 'Anonymous' : ($item->name ?: 'Name not supplied') }}</h3>
<p class="mt-2 max-w-3xl text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($item->request_text, 180) }}</p>
<p class="mt-2 text-xs text-slate-500">{{ $item->created_at->format('j M Y, g:i A') }}</p>
</div>
<div class="flex items-center gap-3">
<span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ \App\Models\PrayerRequest::STATUSES[$item->status] ?? $item->status }}</span>
<a href="{{ route('admin.prayer-requests.show', $item) }}" class="rounded-lg bg-[#072f68] px-4 py-2 text-sm font-semibold text-white">Open</a>
</div>
</div>
</article>
@endforeach
</div>
<div class="mt-6">{{ $requests->links() }}</div>
@endif
</x-admin-layout>
