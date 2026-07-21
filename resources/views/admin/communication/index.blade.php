<x-admin-layout>
<div class="mb-8 flex flex-wrap items-center justify-between gap-4">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[.2em] text-lime-600">Communication Center</p>
        <h1 class="text-3xl font-bold text-[#072f68]">Messages and outreach</h1>
        <p class="mt-2 text-slate-600">Prepare consent-aware email, SMS and WhatsApp communications.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.communication.templates') }}" class="rounded-xl border px-5 py-3 font-semibold text-slate-700">Templates</a>
        <a href="{{ route('admin.communication.create') }}" class="rounded-xl bg-[#072f68] px-5 py-3 font-semibold text-white">Compose message</a>
    </div>
</div>

@if(session('success'))<div class="mb-6 rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>@endif

<div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
@foreach([
 ['Drafts',$stats['drafts'],'✎'],
 ['Scheduled',$stats['scheduled'],'◷'],
 ['Prepared',$stats['prepared'],'✓'],
 ['Recipients',$stats['recipients'],'◎'],
] as [$label,$value,$icon])
<article class="rounded-2xl border bg-white p-5 shadow-sm">
    <div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">{{ $label }}</span><span>{{ $icon }}</span></div>
    <p class="mt-3 text-3xl font-bold text-[#072f68]">{{ $value }}</p>
</article>
@endforeach
</div>

<div class="overflow-hidden rounded-2xl border bg-white shadow-sm">
<table class="min-w-full divide-y divide-slate-200">
<thead class="bg-slate-50"><tr>
<th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Message</th>
<th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Channel</th>
<th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Audience</th>
<th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Status</th>
<th class="px-5 py-4 text-left text-xs uppercase text-slate-500">Recipients</th>
</tr></thead>
<tbody class="divide-y divide-slate-100">
@forelse($messages as $message)
<tr>
<td class="px-5 py-4"><a class="font-bold text-[#072f68]" href="{{ route('admin.communication.show',$message) }}">{{ $message->title }}</a><p class="text-xs text-slate-500">{{ $message->created_at->format('d M Y, H:i') }}</p></td>
<td class="px-5 py-4 uppercase text-sm">{{ $message->channel }}</td>
<td class="px-5 py-4 text-sm">{{ str($message->audience_type)->replace('_',' ')->title() }}</td>
<td class="px-5 py-4"><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold">{{ ucfirst($message->status) }}</span></td>
<td class="px-5 py-4 font-semibold">{{ $message->recipient_count }}</td>
</tr>
@empty
<tr><td colspan="5" class="px-5 py-12 text-center text-slate-500">No communications yet.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-6">{{ $messages->links() }}</div>
</x-admin-layout>
