<x-admin-layout title="Giving Methods | RHMI CMS" heading="Giving Methods">
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div><h2 class="text-2xl font-bold text-[#072f68]">Give & Donations</h2><p class="mt-1 text-sm text-slate-600">Manage MTN Mobile Money, Airtel Money, card giving and other payment instructions.</p></div>
    <a href="{{ route('admin.giving-methods.create') }}" class="rounded-xl bg-lime-500 px-5 py-3 font-bold text-[#072f68]">+ Add Giving Method</a>
</div>
@if(session('success'))<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>@endif
<div class="grid gap-5 lg:grid-cols-2 xl:grid-cols-3">
@forelse($methods as $method)
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <div class="mb-4 flex items-start justify-between gap-3"><div><p class="text-xs font-bold uppercase tracking-wider text-lime-600">{{ $method->provider_label }}</p><h3 class="mt-1 text-lg font-bold text-[#072f68]">{{ $method->title }}</h3></div><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $method->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">{{ $method->is_published ? 'Published' : 'Draft' }}</span></div>
    <div class="space-y-2 text-sm text-slate-600"><p><strong>Account:</strong> {{ $method->account_name ?: 'Not added yet' }}</p><p><strong>Number / Code:</strong> {{ $method->account_number ?: 'Not added yet' }}</p></div>
    <div class="mt-5 flex gap-2"><a href="{{ route('admin.giving-methods.edit',$method) }}" class="flex-1 rounded-lg border border-blue-200 px-4 py-2 text-center text-sm font-semibold text-blue-700">Edit</a><form method="POST" action="{{ route('admin.giving-methods.destroy',$method) }}" class="flex-1" onsubmit="return confirm('Delete this giving method?')">@csrf @method('DELETE')<button class="w-full rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700">Delete</button></form></div>
</article>
@empty
<div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">No giving methods yet.</div>
@endforelse
</div>
</x-admin-layout>
